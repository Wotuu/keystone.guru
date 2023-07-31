<?php

namespace App\Service\CombatLog\Logging;

use Exception;

interface DungeonRouteBuilderLoggingInterface
{
    public function createPullStart(int $killZoneIndex): void;

    public function createPullFindEnemyForGuidStart(string $guid): void;

    public function createPullEnemyNotFound(int $npcId, float $ingameX, float $ingameY): void;

    public function createPullEnemyAttachedToKillZone(int $npcId, float $ingameX, float $ingameY): void;

    public function createPullFindEnemyForGuidEnd(): void;

    public function createPullInsertedEnemies(int $enemyCount): void;

    public function createPullNoEnemiesPullDeleted(): void;

    public function createPullSpellsAttachedToKillZone(int $spellCount): void;

    public function createPullMappingToDifferentNpcId(int $npcId, int $targetNpcId): void;

    public function createPullEnd(): void;

    public function findFloorByUiMapIdNoFloorFound(Exception $exception, int $uitMapId): void;

    public function findUnkilledEnemyForNpcAtIngameLocationStart(int $npcId, float $ingameX, float $ingameY, array $preferredGroups): void;

    public function findUnkilledEnemyForNpcAtIngameLocationEnemyFoundInPreferredGroup(int $id, int $closestEnemyDistance, int $group): void;

    public function findUnkilledEnemyForNpcAtIngameLocationClosestEnemy(?int $enemyId, float $closestEnemyDistance): void;

    public function findUnkilledEnemyForNpcAtIngameLocationEnemyIsBossIgnoringTooFarAwayCheck(): void;

    public function findUnkilledEnemyForNpcAtIngameLocationEnemyTooFarAway(?int $enemyId, float $closestEnemyDistance, int $maxDistance): void;

    public function findUnkilledEnemyForNpcAtIngameLocationEnemyFound(int $enemyId, float $closestEnemyDistance): void;

    public function findUnkilledEnemyForNpcAtIngameLocationEnd(): void;

    public function findClosestEnemyAndDistanceFromList(int $enemiesCount, bool $considerPatrols): void;

    public function findClosestEnemyAndDistanceFromListPriority(int $killPriority, int $enemyCount): void;

    public function findClosestEnemyAndDistanceFromListFoundEnemy(): void;

    public function findClosestEnemyAndDistanceFromListResult(?int $enemyId, float $closestEnemyDistance): void;
}
