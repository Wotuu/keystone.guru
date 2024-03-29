<?php

namespace App\Logic\CombatLog\SpecialEvents;

use App\Logic\CombatLog\CombatEvents\GenericData\GenericDataBuilder;
use App\Logic\CombatLog\CombatEvents\GenericData\GenericDataInterface;

abstract class GenericSpecialEvent extends SpecialEvent
{
    private GenericDataInterface $genericData;

    public function getGenericData(): GenericDataInterface
    {
        return $this->genericData;
    }

    public function setParameters(array $parameters): self
    {
        parent::setParameters($parameters);

        $this->genericData = GenericDataBuilder::create($this->getCombatLogVersion());
        $this->genericData->setParameters(array_slice($parameters, 0, $this->genericData->getParameterCount()));

        return $this;
    }
}
