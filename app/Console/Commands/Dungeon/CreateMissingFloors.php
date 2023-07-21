<?php

namespace App\Console\Commands\Dungeon;

use App\Models\Dungeon;
use App\Models\Floor;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CreateMissingFloors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dungeon:createmissingfloors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the database for dungeons without floors, and if found, looks into the translation files for floors to add and adds them.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle(): int
    {
        /** @var Collection|Dungeon[] $dungeons */
        $dungeons = Dungeon::all()->keyBy('key');

        foreach ($dungeons as $dungeon) {
            // Already exists, we no longer care
            if ($dungeon->floors->isNotEmpty()) {
                continue;
            }

            // Bit of a hack to get the correct translation key..
            $dungeonTranslationKey = explode('.', $dungeon->name)[2];
            $floorsTranslationKey  = sprintf('dungeons.%s.%s.floors', $dungeon->expansion->shortname, $dungeonTranslationKey);

            $translatedFloors = __($floorsTranslationKey, [], 'en');

            $this->info(sprintf('- %s', __($dungeon->name, [], 'en')));
            $index = 1;
            foreach ($translatedFloors as $key => $value) {
                $floorKey = sprintf('%s.%s', $floorsTranslationKey, $key);

                Floor::create([
                    'dungeon_id' => $dungeon->id,
                    'name'       => $floorKey,
                    'index'      => $index,
                    'default'    => $index === 1,
                ]);

                $this->comment(sprintf('-- Added new floor %s', __($floorKey, [], 'en')));

                $index++;
            }
        }

        return 0;
    }
}