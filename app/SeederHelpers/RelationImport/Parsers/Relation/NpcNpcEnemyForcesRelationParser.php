<?php

namespace App\SeederHelpers\RelationImport\Parsers\Relation;

use App\Models\Npc;
use App\Models\Npc\NpcEnemyForces;
use App\Models\NpcSpell;
use Database\Seeders\DatabaseSeeder;

class NpcNpcEnemyForcesRelationParser implements RelationParserInterface
{
    /**
     * @return bool
     */
    public function canParseRootModel(string $modelClassName): bool
    {
        return false;
    }

    /**
     * @param string $modelClassName
     * @return bool
     */
    public function canParseModel(string $modelClassName): bool
    {
        return $modelClassName === Npc::class;
    }

    /**
     * @param string $name
     * @param array  $value
     * @return bool
     */
    public function canParseRelation(string $name, array $value): bool
    {
        return $name === 'npc_enemy_forces';
    }

    /**
     * @param string $modelClassName
     * @param array  $modelData
     * @param string $name
     * @param array  $value
     * @return array
     */
    public function parseRelation(string $modelClassName, array $modelData, string $name, array $value): array
    {
        NpcEnemyForces::from(DatabaseSeeder::getTempTableName(NpcEnemyForces::class))->insert($value);

        // Didn't really change anything so just return the value.
        return $modelData;
    }

}
