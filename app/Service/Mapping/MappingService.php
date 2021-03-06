<?php


namespace App\Service\Mapping;

use App\Models\Dungeon;
use App\Models\Floor;
use App\Models\Mapping\MappingChangeLog;
use App\Models\Mapping\MappingCommitLog;
use Illuminate\Support\Collection;

class MappingService implements MappingServiceInterface
{
    function shouldSynchronizeMapping(): bool
    {
        /** @var MappingChangeLog $mostRecentMappingChangeLog */
        $mostRecentMappingChangeLog = MappingChangeLog::latest()->first();

        /** @var MappingCommitLog $mostRecentMappingCommitLog */
        $mostRecentMappingCommitLog = MappingCommitLog::latest()->first();

        // If not synced at all yet, or if we've synced, but it was before any changes were done
        return $mostRecentMappingChangeLog !== null && ($mostRecentMappingCommitLog === null || $mostRecentMappingChangeLog->shouldSynchronize($mostRecentMappingCommitLog));
    }

    /**
     * @param bool $ignoreMostRecentCommit
     * @return Collection|MappingChangeLog[]
     */
    function getUnsynchronizedMappingChanges(bool $ignoreMostRecentCommit = false): Collection
    {
        /** @var MappingCommitLog $mostRecentMappingCommitLog */
        if ($ignoreMostRecentCommit) {
            $allCommits = MappingCommitLog::all();
            $mostRecentMappingCommitLog = $allCommits->count() > 1 ? $allCommits->get($allCommits->count() - 2) : null;
        } else {
            $mostRecentMappingCommitLog = MappingCommitLog::latest()->first();
        }

        if ($mostRecentMappingCommitLog !== null) {
            $result = MappingChangeLog::where('created_at', '>', $mostRecentMappingCommitLog->created_at->toDateTimeString())->get();
        } else {
            $result = MappingChangeLog::all();
        }

        return $result;
    }

    /**
     * @param bool $ignoreMostRecentCommit
     * @return Collection|Dungeon[]
     */
    function getRecentlyChangedDungeons(bool $ignoreMostRecentCommit = false): Collection
    {
        /** @var Collection|Dungeon[] $result */
        $result = collect();

        $mostRecentMappingChanges = $this->getUnsynchronizedMappingChanges($ignoreMostRecentCommit);

        foreach ($mostRecentMappingChanges as $mappingChange) {
            // Decode the latest known value
            $decoded = json_decode(!empty($mappingChange->after_model) ? $mappingChange->after_model : $mappingChange->before_model, true);

            // Only if we actually decoded something; prevents crashes
            if ($decoded !== false && isset($decoded['floor_id'])) {
                $changedFloor = Floor::find($decoded['floor_id']);

                // If we found the floor that was changed, add its dungeon to the list if it wasn't already in there
                if ($changedFloor !== null) {
                    $exists = false;

                    foreach ($result as $dungeon) {
                        if ($dungeon->id === $changedFloor->dungeon_id) {
                            $exists = true;
                            break;
                        }
                    }


                    if (!$exists) {
                        $result->add($changedFloor->dungeon);
                    }
                }
            }
        }

        return $result;
    }


}