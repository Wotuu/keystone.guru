<?php

namespace App\Service\CombatLog\Logging;

use App\Logging\StructuredLogging;

class CreateRouteDungeonRouteServiceLogging extends StructuredLogging implements CreateRouteDungeonRouteServiceLoggingInterface
{

    /**
     * @inheritDoc
     */
    public function getCreateRouteBodyStart(string $combatLogFilePath): void
    {
        $this->start(__METHOD__, get_defined_vars());
    }
    
    /**
     * @inheritDoc
     */
    public function getCreateRouteBodyEnd(): void
    {
        $this->end(__METHOD__, get_defined_vars());
    }
}