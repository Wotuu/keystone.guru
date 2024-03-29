<?php

namespace App\Service\CombatLog\Filters\DungeonRoute;

use App\Logic\CombatLog\BaseEvent;
use App\Logic\CombatLog\SpecialEvents\ChallengeModeEnd;
use App\Logic\CombatLog\SpecialEvents\ChallengeModeStart;
use App\Service\CombatLog\Exceptions\DungeonNotSupportedException;
use App\Service\CombatLog\Exceptions\FloorNotSupportedException;
use App\Service\CombatLog\Filters\BaseSpecialEventsFilter;
use App\Service\CombatLog\ResultEvents\ChallengeModeEnd as ChallengeModeEndResultEvent;
use App\Service\CombatLog\ResultEvents\ChallengeModeStart as ChallengeModeStartResultEvent;

class SpecialEventsFilter extends BaseSpecialEventsFilter
{
    private ?ChallengeModeStart $challengeModeStartEvent = null;

    /**
     * @throws DungeonNotSupportedException
     * @throws FloorNotSupportedException
     */
    public function parse(BaseEvent $combatLogEvent, int $lineNr): bool
    {
        // Starts
        if ($combatLogEvent instanceof ChallengeModeStart) {
            $this->challengeModeStartEvent = $combatLogEvent;

            $this->resultEvents->push((new ChallengeModeStartResultEvent($combatLogEvent)));

            return true;
        } // Ends
        else if ($combatLogEvent instanceof ChallengeModeEnd &&
            $this->challengeModeStartEvent instanceof ChallengeModeStart) {
            $this->resultEvents->push((new ChallengeModeEndResultEvent($this->challengeModeStartEvent, $combatLogEvent)));

            return true;
        }

        return parent::parse($combatLogEvent, $lineNr);
    }
}
