<?php

namespace App\Service\ChallengeModeRunData;

use App\Models\CombatLog\ChallengeModeRunData;

interface ChallengeModeRunDataServiceInterface
{
    public function convert(bool $translate = true): bool;

    public function convertChallengeModeRunData(ChallengeModeRunData $challengeModeRunData): bool;

    public function convertChallengeModeRunDataAndTranslate(ChallengeModeRunData $challengeModeRunData): bool;

    public function insertAllToOpensearch(): bool;
}
