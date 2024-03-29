<?php

namespace App\Service\CombatLog\Logging;

use App\Logging\RollbarStructuredLogging;

class CreateRouteDungeonRouteServiceLogging extends RollbarStructuredLogging implements CreateRouteDungeonRouteServiceLoggingInterface
{
    /**
     * {@inheritDoc}
     */
    public function getCreateRouteBodyStart(string $combatLogFilePath): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateRouteBodyEnemyEngagedInvalidNpcId(int $npcId): void
    {
        $this->info(__METHOD__, get_defined_vars());
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateRouteBodyEnemyKilledInvalidNpcId(int $npcId): void
    {
        $this->info(__METHOD__, get_defined_vars());
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateRouteBodyEnd(): void
    {
        $this->end(__METHOD__, get_defined_vars());
    }

    /**
     * {@inheritDoc}
     */
    public function saveChallengeModeRunUnableToFindFloor(int $uiMapId): void
    {
        $this->warning(__METHOD__, get_defined_vars());
    }

    /**
     * {@inheritDoc}
     */
    public function generateMapIconsUnableToFindFloor(string $uniqueId): void
    {
        $this->warning(__METHOD__, get_defined_vars());
    }
}
