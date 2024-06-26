<?php

namespace App\Service\ChallengeModeRunData;

use App\Models\CombatLog\ChallengeModeRunData;

interface ChallengeModeRunDataServiceInterface
{
    public function convert(bool $force = false, ?callable $onProcess = null): bool;

    public function convertChallengeModeRunData(ChallengeModeRunData $challengeModeRunData): bool;

    public function insertAllToOpensearch(int $count = 1000, ?callable $onProcess = null): bool;
}
