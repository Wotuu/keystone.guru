<?php

namespace App\Logic\CombatLog\SpecialEvents;

use App\Logic\CombatLog\Guid\Guid;

class CombatantInfo extends SpecialEvent
{
    private Guid $playerGuid;

    public function getPlayerGuid(): ?Guid
    {
        return $this->playerGuid;
    }

    public function setParameters(array $parameters): self
    {
        parent::setParameters($parameters);

        // If GUID is null at this point this will crash - but that's okay, we NEED this to be set
        $this->playerGuid = Guid::createFromGuidString($parameters[0]);

        return $this;
    }

    public function getOptionalParameterCount(): int
    {
        // This event has a lot of variables because it uses an incorrect delimiter to escape the contents ( "(" and ")" )
        return 1000;
    }

    public function getParameterCount(): int
    {
        return 1000;
    }
}
