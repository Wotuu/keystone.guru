<?php

namespace App\Logic\CombatLog\CombatEvents\Suffixes;

use App\Logic\CombatLog\CombatEvents\Interfaces\HasParameters;

abstract class AuraBase extends Suffix
{
    /** @var string ex. BUFF */
    private string $auraType;

    private int $amount;

    public function getAuraType(): string
    {
        return $this->auraType;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return HasParameters|$this
     */
    public function setParameters(array $parameters): HasParameters
    {
        parent::setParameters($parameters);

        $this->auraType = $parameters[0];
        if (isset($parameters[1])) {
            $this->amount = $parameters[1];
        }

        return $this;
    }

    public function getOptionalParameterCount(): int
    {
        return 1;
    }

    public function getParameterCount(): int
    {
        return 2;
    }
}
