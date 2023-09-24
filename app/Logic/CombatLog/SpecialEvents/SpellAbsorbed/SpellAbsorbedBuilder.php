<?php

namespace App\Logic\CombatLog\SpecialEvents\SpellAbsorbed;

use App\Logic\CombatLog\CombatLogVersion;
use App\Logic\CombatLog\SpecialEvents\SpecialEvent;
use App\Logic\CombatLog\SpecialEvents\SpecialEventBuilderInterface;
use App\Logic\CombatLog\SpecialEvents\SpellAbsorbed\Versions\V20\SpellAbsorbedV20;
use App\Logic\CombatLog\SpecialEvents\SpellAbsorbed\Versions\V9\SpellAbsorbedV9;
use Carbon\Carbon;

class SpellAbsorbedBuilder implements SpecialEventBuilderInterface
{
    /**
     * @param int    $combatLogVersion
     * @param Carbon $timestamp
     * @param string $eventName
     * @param array  $parameters
     * @param string $rawEvent
     * @return SpecialEvent|SpellAbsorbedInterface
     */
    public static function create(
        int    $combatLogVersion,
        Carbon $timestamp,
        string $eventName,
        array  $parameters,
        string $rawEvent
    ): SpecialEvent
    {
        switch ($combatLogVersion) {
            case CombatLogVersion::CLASSIC:
                return new SpellAbsorbedV9($combatLogVersion, $timestamp, $eventName, $parameters, $rawEvent);
            default:
                return new SpellAbsorbedV20($combatLogVersion, $timestamp, $eventName, $parameters, $rawEvent);
        }
    }
}