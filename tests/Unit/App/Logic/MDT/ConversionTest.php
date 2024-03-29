<?php

namespace Tests\Unit\App\Logic\MDT;

use App\Logic\MDT\Conversion;
use App\Models\Expansion;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ConversionTest extends TestCase
{
    /**
     * A basic test example.
     */
    #[Test]
    #[DataProvider('checkGetExpansionName_GivenDungeonKey_ShouldBeCorrect_Provider')]
    #[Group('')]
    public function checkGetExpansionName_GivenDungeonKey_ShouldBeCorrect(string $dungeonKey, string $expectedExpansionKey): void
    {
        // Test
        $expansionKey = Conversion::getExpansionName($dungeonKey);

        // Assert
        $this->assertEquals($expansionKey, $expectedExpansionKey);
    }

    public static function checkGetExpansionName_GivenDungeonKey_ShouldBeCorrect_Provider(): array
    {
        $expansions = [
            Expansion::EXPANSION_CATACLYSM,
            Expansion::EXPANSION_MOP,
            Expansion::EXPANSION_LEGION,
            Expansion::EXPANSION_BFA,
            Expansion::EXPANSION_SHADOWLANDS,
            Expansion::EXPANSION_DRAGONFLIGHT,
        ];

        $result = [];
        foreach ($expansions as $expansion) {
            foreach (Conversion::DUNGEON_NAME_MAPPING[$expansion] as $dungeonKey => $value) {
                $result[] = [$dungeonKey, $expansion];
            }
        }

        return $result;
    }
}
