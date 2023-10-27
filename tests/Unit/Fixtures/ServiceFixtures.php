<?php

namespace Tests\Unit\Fixtures;

use App\Models\Season;
use App\Service\CombatLog\CombatLogService;
use App\Service\CombatLog\CombatLogServiceInterface;
use App\Service\CombatLog\Logging\CombatLogDungeonRouteServiceLoggingInterface;
use App\Service\CombatLog\Logging\CombatLogServiceLoggingInterface;
use App\Service\CombatLog\ResultEventDungeonRouteService;
use App\Service\CombatLog\ResultEventDungeonRouteServiceInterface;
use App\Service\Coordinates\CoordinatesService;
use App\Service\Coordinates\CoordinatesServiceInterface;
use App\Service\Expansion\ExpansionService;
use App\Service\Expansion\ExpansionServiceInterface;
use App\Service\Season\SeasonService;
use App\Service\Season\SeasonServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\PublicTestCase;

class ServiceFixtures
{
    /**
     * @param PublicTestCase                   $testCase
     * @param CombatLogServiceLoggingInterface $log
     * @param array                            $methodsNotToMock
     * @return MockObject|CombatLogServiceInterface
     */
    public static function getCombatLogServiceMock(
        PublicTestCase                   $testCase,
        CombatLogServiceLoggingInterface $log,
        array                            $methodsNotToMock = []
    ): MockObject {
        return $testCase
            ->getMockBuilder(CombatLogService::class)
            ->setConstructorArgs([
                $log,
            ])
            ->setMethods(null)
            ->getMock();
    }

    /**
     * @param PublicTestCase                               $testCase
     * @param CombatLogService                             $combatLogService
     * @param CombatLogDungeonRouteServiceLoggingInterface $log
     * @param array                                        $methodsNotToMock
     *
     * @return MockObject|ResultEventDungeonRouteServiceInterface
     */
    public static function getResultEventDungeonRouteServiceMock(
        PublicTestCase                               $testCase,
        CombatLogService                             $combatLogService,
        CombatLogDungeonRouteServiceLoggingInterface $log,
        array                                        $methodsNotToMock = []
    ): MockObject {
        return $testCase
            ->getMockBuilder(ResultEventDungeonRouteService::class)
            ->setConstructorArgs([
                $combatLogService,
                $log,
            ])
            ->setMethods(null)
            ->getMock();
    }

    /**
     * @param PublicTestCase $testCase
     * @param array          $methodsNotToMock
     * @return ExpansionServiceInterface
     */
    public static function getExpansionServiceMock(
        PublicTestCase $testCase,
        array          $methodsNotToMock = []
    ): ExpansionServiceInterface {
        return $testCase->createMock(ExpansionService::class);
    }

    /**
     * @param PublicTestCase  $testCase
     * @param array           $methodsNotToMock
     * @param Collection|null $seasons
     * @return MockObject|SeasonServiceInterface
     */
    public static function getSeasonServiceMock(
        PublicTestCase $testCase,
        array          $methodsNotToMock = [],
        Collection     $seasons = null): SeasonServiceInterface
    {
        $seasonServiceMockBuilder = $testCase
            ->getMockBuilder(SeasonService::class)
            ->setConstructorArgs([
                self::getExpansionServiceMock($testCase),
            ]);
        $seasonServiceMockBuilder->onlyMethods(['getSeasons']);

        $seasonServiceMock = $seasonServiceMockBuilder->getMock();
        $seasonServiceMock->method('getSeasons')
            ->willReturn($seasons ?? collect([
                new Season([
                    'start'             => Carbon::now()->subYear(),
                    'affix_group_count' => 12,
                ]),
            ]));

        return $seasonServiceMock;
    }

    /**
     * @param PublicTestCase $testCase
     * @param array          $methodsNotToMock
     * @return MockObject|CoordinatesServiceInterface
     */
    public static function getCoordinatesServiceMock(
        PublicTestCase $testCase,
        array          $methodsNotToMock = []
    ): MockObject {
        return $testCase
            ->getMockBuilder(CoordinatesService::class)
            ->setMethods(null)
            ->getMock();
    }
}
