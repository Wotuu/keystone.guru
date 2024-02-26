<?php

namespace Database\Seeders;

use App\Models\NpcClass;
use Illuminate\Database\Seeder;

class NpcClassesSeeder extends Seeder implements TableSeederInterface
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Adding known Npc classes');

        $npcClassAttributes = [];
        foreach (NpcClass::ALL as $key) {
            $npcClassAttributes[] = [
                'key' => $key,
                'name' => sprintf('npcclasses.%s', $key),
            ];
        }

        NpcClass::from(DatabaseSeeder::getTempTableName(NpcClass::class))->insert($npcClassAttributes);
    }

    public static function getAffectedModelClasses(): array
    {
        return [
            NpcClass::class,
        ];
    }
}
