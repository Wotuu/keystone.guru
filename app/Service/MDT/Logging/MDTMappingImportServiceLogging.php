<?php

namespace App\Service\MDT\Logging;

use App\Logging\RollbarStructuredLogging;
use Exception;

class MDTMappingImportServiceLogging extends RollbarStructuredLogging implements MDTMappingImportServiceLoggingInterface
{
    public function importMappingVersionFromMDTMappingChanged(?string $mdtMappingHash, string $latestMdtMappingHash): void
    {
        $this->info(__METHOD__, get_defined_vars());
    }

    public function importMappingVersionFromMDTCreateMappingVersion(int $version, int $id): void
    {
        $this->info(__METHOD__, get_defined_vars());
    }

    public function importMappingVersionFromMDTStart(int $dungeonId): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }

    public function importMappingVersionFromMDTEnd(): void
    {
        $this->end(__METHOD__, get_defined_vars());
    }

    public function importDungeonStart(): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }

    public function importDungeonTotalCounts(int $mdtDungeonID, int $normal, int $teeming): void
    {
        $this->info(__METHOD__, get_defined_vars());
    }

    public function importDungeonOK(): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importDungeonFailed(): void
    {
        $this->error(__METHOD__, get_defined_vars());
    }

    public function importDungeonEnd(): void
    {
        $this->end(__METHOD__, get_defined_vars());
    }

    public function importNpcsStart(): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }

    public function importNpcsSaveNewNpc(int $npcId): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importNpcsUpdateExistingNpc(int $npcId): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importNpcsSaveNpcException(Exception $exception): void
    {
        $this->error(__METHOD__, get_defined_vars());
    }

    public function importNpcsEnd(): void
    {
        $this->end(__METHOD__, get_defined_vars());
    }

    public function importEnemiesStart(): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }

    public function importEnemiesSkipIgnoredByNpcEnemy(string $uniqueKey): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemiesSkipTeemingEnemy(string $uniqueKey): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemiesRecoverPropertiesFromExistingEnemy(string $uniqueKey, array $updatedFields): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemiesCannotRecoverPropertiesFromExistingEnemy(string $uniqueKey): void
    {
        $this->error(__METHOD__, get_defined_vars());
    }

    public function importEnemiesSaveNewEnemy(int $enemyId): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemiesSaveNewEnemyException(Exception $exception): void
    {
        $this->error(__METHOD__, get_defined_vars());
    }

    public function importEnemiesEnd(): void
    {
        $this->end(__METHOD__, get_defined_vars());
    }

    public function importEnemyPacksStart(): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }

    public function importEnemyPacksSaveNewEnemyPackOK(int $enemyPackId, int $count): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemyPacksCoupleEnemyToPackStart(int $enemyPackId): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }

    public function importEnemyPacksCoupleEnemyToEnemyPack(int $enemyId): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemyPacksCoupleEnemyToPackEnd(): void
    {
        $this->end(__METHOD__, get_defined_vars());
    }

    public function importEnemyPacksEnd(): void
    {
        $this->end(__METHOD__, get_defined_vars());
    }

    public function importEnemyPatrolsStart(): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }

    public function importEnemyPatrolsEnemyHasPatrol(string $uniqueKey): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemyPatrolsFoundPatrolIsEmpty(string $uniqueKey): void
    {
        $this->warning(__METHOD__, get_defined_vars());
    }

    public function importEnemyPatrolsSaveNewPolyline(int $polylineId): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemyPatrolsSaveNewEnemyPatrol(int $enemyPatrolId): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemyPatrolsCoupleEnemyPatrolToPolyline(int $enemyPatrolId, int $polylineId): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemyPatrolsCoupleEnemiesToEnemyPatrol(int $enemyPatrolId): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importEnemyPatrolsEnd(): void
    {
        $this->end(__METHOD__, get_defined_vars());
    }

    public function importDungeonFloorSwitchMarkersStart(): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }

    public function importDungeonFloorSwitchMarkersImportFromMDT(): void
    {
        $this->debug(__METHOD__);
    }

    public function importDungeonFloorSwitchMarkersNewDungeonFloorSwitchMarkerOK(int $dungeonFloorSwitchMarkerId, int $floorId, int $targetFloorId): void
    {
        $this->debug(__METHOD__, get_defined_vars());
    }

    public function importDungeonFloorSwitchMarkersHaveExistingFloorSwitchMarkers(int $count): void
    {
        $this->info(__METHOD__, get_defined_vars());
    }

    public function importDungeonFloorSwitchMarkersEnd(): void
    {
        $this->end(__METHOD__, get_defined_vars());
    }
}
