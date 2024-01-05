<?php


namespace App\Service\DungeonRoute;

use App\Jobs\ProcessRouteFloorThumbnail;
use App\Models\DungeonRoute;
use App\Models\Floor\Floor;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Symfony\Component\Process\Process;

class ThumbnailService implements ThumbnailServiceInterface
{
    const THUMBNAIL_FOLDER_PATH = 'images/route_thumbnails/';

    /**
     * @inheritDoc
     */
    public function refreshThumbnail(DungeonRoute $dungeonRoute, int $floorIndex, int $attempts = 0): void
    {
        if (app()->isDownForMaintenance()) {
            Log::channel('scheduler')->info('Not generating thumbnail - app is down for maintenance');

            return;
        }

        // 1. Headless chrome saves file in a temp location
        // 2. File is downsized to a smaller thumbnail (can't make the browser window smaller since that'd mess up the image)
        // 3. Moved to public folder

        $filename = $this->getFilename($dungeonRoute, $floorIndex);

        $tmpFile    = sprintf('/tmp/%s', $filename);
        $publicPath = public_path(self::THUMBNAIL_FOLDER_PATH);
        $target     = $this->getTargetFilePath($dungeonRoute, $floorIndex);

        // puppeteer chromium-browser
        $process = new Process([
            'node',
            // Script to execute
            resource_path('assets/puppeteer/route_thumbnail.js'),
            // First argument; where to navigate
            route('dungeonroute.preview', [
                'dungeon'      => $dungeonRoute->dungeon,
                'dungeonroute' => $dungeonRoute->public_key,
                'title'        => $dungeonRoute->getTitleSlug(),
                'floorindex'   => $floorIndex,
                'secret'       => config('keystoneguru.thumbnail.preview_secret'),
            ]),
            // Second argument; where to save the resulting image
            $tmpFile,
        ]);

        Log::channel('scheduler')->info($process->getCommandLine());

        $process->run();

        if ($process->isSuccessful()) {
            if (!file_exists($tmpFile)) {
                Log::channel('scheduler')->error('Unable to find generated thumbnail; did puppeteer download Chromium?');
            } else {
                try {
                    // We've updated the thumbnail; make sure the route is updated so it doesn't get updated anymore
                    $dungeonRoute->thumbnail_updated_at = \Illuminate\Support\Carbon::now()->toDateTimeString();
                    // Do not update the timestamps of the route! Otherwise we'll just keep on updating the timestamp
                    $dungeonRoute->timestamps = false;
                    $dungeonRoute->save();

                    // Ensure our write path exists
                    if (!is_dir($publicPath)) {
                        mkdir($publicPath, 0755, true);
                    }

                    // Rescale it
                    Log::channel('scheduler')->info(sprintf('Scaling and moving image from %s to %s', $tmpFile, $target));
                    Image::make($tmpFile)->resize(384, 256)->save($target);

                    Log::channel('scheduler')->info(
                        sprintf('Check if %s exists: %s', $target, var_export(file_exists($target), true))
                    );
                    // Image now exists in target location; compress it and move it to the target location
                    // Log::channel('scheduler')->info('Compressing image..');
                    // $this->compressPng($tmpScaledFile, $target);
                } finally {
                    // Cleanup
                    if (file_exists($tmpFile)) {
                        if (unlink($tmpFile)) {
                            Log::channel('scheduler')->info('Removing tmp file success..');
                        } else {
                            Log::channel('scheduler')->warning('Removing tmp file failure!');
                        }
                    }
                    // unlink($tmpScaledFile);
                }
            }
        }

        // Log any errors that may have occurred
        $errors = $process->getErrorOutput();
        if (!empty($errors)) {
            Log::channel('scheduler')->error($errors, [
                'dungeonRoute' => $dungeonRoute->public_key,
                'floor'        => $floorIndex,
            ]);

            // If there were errors, try again
            ProcessRouteFloorThumbnail::dispatch($this, $dungeonRoute, $floorIndex, ++$attempts);
        }
    }

    /**
     * @inheritDoc
     */
    public function queueThumbnailRefresh(DungeonRoute $dungeonRoute): bool
    {
        $result = false;

        foreach ($dungeonRoute->dungeon->floorsForMapFacade(true)->active()->get() as $floor) {
            /** @var Floor $floor */
            // Set it for processing in a queue
            ProcessRouteFloorThumbnail::dispatch($this, $dungeonRoute, $floor->index);
            $result = true;
        }

        // Temporarily disable timestamps since we don't want this action to update the updated_at
        $dungeonRoute->timestamps                  = false;
        $dungeonRoute->thumbnail_refresh_queued_at = Carbon::now()->toDateTimeString();
        $dungeonRoute->save();

        // Re-enable them
        $dungeonRoute->timestamps = true;

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getFileName(DungeonRoute $dungeonRoute, int $floorIndex): string
    {
        return sprintf('%s_%s.png', $dungeonRoute->public_key, $floorIndex);
    }

    /**
     * @inheritDoc
     */
    public function getTargetFilePath(DungeonRoute $dungeonRoute, int $floorIndex): string
    {
        return public_path(sprintf('images/route_thumbnails/%s', $this->getFilename($dungeonRoute, $floorIndex)));
    }

    /**
     * @inheritDoc
     */
    public function copyThumbnails(DungeonRoute $sourceDungeonRoute, DungeonRoute $targetDungeonRoute): bool
    {
        // If the dungeons don't match then this doesn't make sense
        if (!$sourceDungeonRoute->has_thumbnail || $sourceDungeonRoute->dungeon_id !== $targetDungeonRoute->dungeon_id) {
            return false;
        }

        $result = true;

        // Copy over all thumbnails
        foreach ($sourceDungeonRoute->dungeon->floors()->where('facade', 0)->get() as $floor) {
            $sourcePath = $this->getTargetFilePath($sourceDungeonRoute, $floor->index);
            $targetPath = $this->getTargetFilePath($targetDungeonRoute, $floor->index);

            if (!File::exists($sourcePath) || !File::exists($targetPath)) {
                continue;
            }

            try {
                $result = $result && File::copy($sourcePath, $targetPath);
            } catch (\Exception $exception) {
                $result = false;

                logger()->error($exception->getMessage(), [
                    'exception' => $exception,
                ]);
            }
        }

        return $result;
    }

    /**
     * @param DungeonRoute $dungeonRoute
     * @return bool
     */
    public function hasThumbnailsGenerated(DungeonRoute $dungeonRoute): bool
    {
        $result = true;
        foreach ($dungeonRoute->dungeon->floors()->active()->get() as $floor) {
            $result = $result && file_exists($dungeonRoute->getThumbnailPath($floor));
        }

        return $result;
    }
}
