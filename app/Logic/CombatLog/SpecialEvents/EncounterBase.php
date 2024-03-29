<?php

namespace App\Logic\CombatLog\SpecialEvents;

/**
 * ENCOUNTER_START,2111,"Elder Leaxa",8,5,1841
 *
 * @author Wouter
 *
 * @since 26/05/2023
 */
abstract class EncounterBase extends SpecialEvent
{
    private int $encounterID;

    private string $encounterName;

    private int $difficultyID;

    private int $groupSize;

    public function getEncounterID(): int
    {
        return $this->encounterID;
    }

    public function getEncounterName(): string
    {
        return $this->encounterName;
    }

    public function getDifficultyID(): int
    {
        return $this->difficultyID;
    }

    public function getGroupSize(): int
    {
        return $this->groupSize;
    }

    public function setParameters(array $parameters): self
    {
        parent::setParameters($parameters);

        $this->encounterID   = $parameters[0];
        $this->encounterName = $parameters[1];
        $this->difficultyID  = $parameters[2];
        $this->groupSize     = $parameters[3];

        return $this;
    }
}
