<?php

namespace App\Service\CombatLog\Filters;

use App\Logic\CombatLog\BaseEvent;
use App\Logic\CombatLog\CombatEvents\AdvancedCombatLogEvent;
use App\Logic\CombatLog\CombatEvents\Prefixes\Spell as SpellPrefix;
use App\Logic\CombatLog\CombatEvents\Suffixes\CastSuccess;
use App\Models\Spell;
use App\Service\CombatLog\Interfaces\CombatLogParserInterface;
use App\Service\CombatLog\ResultEvents\SpellCast;
use Illuminate\Support\Collection;

class SpellFilter implements CombatLogParserInterface
{
    private Collection $resultEvents;

    private Collection $spellsToTrack;

    /**
     * @param Collection $resultEvents
     */
    public function __construct(Collection $resultEvents)
    {
        $this->resultEvents = $resultEvents;

        $this->spellsToTrack = Spell::where('selectable', true)->get()->pluck('id');
    }

    /**
     * @param BaseEvent $combatLogEvent
     * @param int       $lineNr
     *
     * @return bool
     */
    public function parse(BaseEvent $combatLogEvent, int $lineNr): bool
    {
        if (!($combatLogEvent instanceof AdvancedCombatLogEvent)) {
            return false;
        }

        if (!($combatLogEvent->getPrefix() instanceof SpellPrefix) || !($combatLogEvent->getSuffix() instanceof CastSuccess)) {
            return false;
        }

        /** @var SpellPrefix $prefix */
        $prefix = $combatLogEvent->getPrefix();

        $isValidSpell = $this->spellsToTrack->search($prefix->getSpellId()) !== false;
        if ($isValidSpell) {
            $this->resultEvents->push(new SpellCast($combatLogEvent));
        }

        return $isValidSpell;
    }
}