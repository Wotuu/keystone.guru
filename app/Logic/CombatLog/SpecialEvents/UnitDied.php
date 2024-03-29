<?php

namespace App\Logic\CombatLog\SpecialEvents;

/**
 * UNIT_DIED,0000000000000000,nil,0x80000000,0x80000000,Creature-0-4242-1841-14566-131402-0005E285EB,"Underrot Tick",0xa48,0x0,0
 *
 * @author Wouter
 *
 * @since 26/05/2023
 */
class UnitDied extends GenericSpecialEvent
{
    private bool $unconsciousOnDeath;

    public function isUnconsciousOnDeath(): bool
    {
        return $this->unconsciousOnDeath;
    }

    public function setParameters(array $parameters): self
    {
        parent::setParameters($parameters);

        $this->unconsciousOnDeath = (bool)$parameters[8];

        return $this;
    }

    public function getParameterCount(): int
    {
        return 9;
    }
}
