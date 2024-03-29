<?php

namespace Tests\Unit\Fixtures;

use App\Models\Season;
use Tests\TestCases\PublicTestCase;

class ModelFixtures
{
    public static function getSeasonMock(PublicTestCase $testCase, array $attributes): Season
    {
        return $testCase->createMock(Season::class);
    }
}
