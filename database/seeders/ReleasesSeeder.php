<?php

namespace Database\Seeders;

use App\Models\Release;
use App\Models\ReleaseChangelog;
use App\Models\ReleaseChangelogChange;
use FilesystemIterator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReleasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->rollback();

        $this->command->info('Adding releases');
        $rootDir         = database_path('seeders/releases/');
        $rootDirIterator = new FilesystemIterator($rootDir);

        // Keep a list of all data that we must insert
        $releaseChangeLogChangesAttributes = [];
        $releaseChangeLogAttributes        = [];
        $releaseAttributes                 = [];

        // Iterate over all saved releases
        foreach ($rootDirIterator as $releaseData) {
            $modelJson = file_get_contents($releaseData);
            // Convert to models
            $modelsData = json_decode($modelJson, true);

            // If it has a changelog (should)
            if (isset($modelsData['changelog'])) {
                $changelogData = $modelsData['changelog'];
                // Changelog
                $releaseChangeLogAttributes[] = array_filter($changelogData, function ($value) {
                    return !is_array($value);
                });

                // Save the changes for each changelog
                foreach ($changelogData['changes'] as $changeData) {
                    // Changelog changes
                    $releaseChangeLogChangesAttributes[] = array_filter($changeData, function ($value) {
                        return !is_array($value);
                    });
                }
            }

            // Save the release last!
            $this->command->info(sprintf('Adding release %s', $modelsData['version']));
            /** @var array{created_at: \Carbon\Carbon, updated_at: \Carbon\Carbon} $releaseAttribute */
            $releaseAttribute = array_filter($modelsData, function ($value) {
                return !is_array($value);
            });
            
            $releaseAttribute['created_at'] = Carbon::createFromFormat(Release::$SERIALIZED_DATE_TIME_FORMAT, $releaseAttribute['created_at'])->toDateTimeString();
            $releaseAttribute['updated_at'] = Carbon::createFromFormat(Release::$SERIALIZED_DATE_TIME_FORMAT, $releaseAttribute['updated_at'])->toDateTimeString();
            
            $releaseAttributes[] = $releaseAttribute;
        }

        $this->command->info(sprintf('Inserting %d releases..', count($releaseAttributes)));
        
        Release::insert($releaseAttributes);
        ReleaseChangelog::insert($releaseChangeLogAttributes);
        ReleaseChangelogChange::insert($releaseChangeLogChangesAttributes);
        
        $this->command->info(sprintf('Inserting %d releases OK', count($releaseAttributes)));
    }

    private function rollback()
    {
        DB::table('releases')->truncate();
        DB::table('release_changelogs')->truncate();
        DB::table('release_changelog_changes')->truncate();
    }
}
