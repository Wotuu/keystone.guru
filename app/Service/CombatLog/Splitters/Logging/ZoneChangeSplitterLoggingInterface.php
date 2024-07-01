<?php

namespace App\Service\CombatLog\Splitters\Logging;

interface ZoneChangeSplitterLoggingInterface extends CombatLogSplitterLoggingInterface
{

    public function parseCombatLogEventTimestampNotSet(): void;

    public function parseCombatLogEventTooBigTimestampGap(int $seconds, string $previousTimestamp, string $timestamp): void;

    public function parseCombatLogEventZoneChangeEvent(): void;

    public function parseCombatLogEventCombatLogVersionEvent(): void;

    public function resetCurrentZone(): void;

    public function reset(): void;
}
