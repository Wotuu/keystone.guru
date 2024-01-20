<?php

namespace App\Service\MapContext;

use App\Logic\MapContext\MapContextDungeonExplore;
use App\Logic\MapContext\MapContextDungeonRoute;
use App\Logic\MapContext\MapContextLiveSession;
use App\Logic\MapContext\MapContextMappingVersionEdit;
use App\Models\Dungeon;
use App\Models\DungeonRoute\DungeonRoute;
use App\Models\Floor\Floor;
use App\Models\LiveSession;
use App\Models\Mapping\MappingVersion;
use App\Service\Cache\CacheServiceInterface;
use App\Service\Coordinates\CoordinatesServiceInterface;
use App\Service\LiveSession\OverpulledEnemyServiceInterface;

class MapContextService implements MapContextServiceInterface
{
    private CacheServiceInterface $cacheService;

    private CoordinatesServiceInterface $coordinatesService;

    private OverpulledEnemyServiceInterface $overpulledEnemyService;

    /**
     * @param CacheServiceInterface           $cacheService
     * @param CoordinatesServiceInterface     $coordinatesService
     * @param OverpulledEnemyServiceInterface $overpulledEnemyService
     */
    public function __construct(CacheServiceInterface $cacheService, CoordinatesServiceInterface $coordinatesService, OverpulledEnemyServiceInterface $overpulledEnemyService)
    {
        $this->cacheService           = $cacheService;
        $this->coordinatesService     = $coordinatesService;
        $this->overpulledEnemyService = $overpulledEnemyService;
    }

    /**
     * @param DungeonRoute $dungeonRoute
     * @param Floor        $floor
     *
     * @return MapContextDungeonRoute
     */
    public function createMapContextDungeonRoute(DungeonRoute $dungeonRoute, Floor $floor): MapContextDungeonRoute
    {
        return new MapContextDungeonRoute(
            $this->cacheService,
            $this->coordinatesService,
            $dungeonRoute,
            $floor
        );
    }

    /**
     * @param LiveSession $liveSession
     * @param Floor       $floor
     *
     * @return MapContextLiveSession
     */
    public function createMapContextLiveSession(LiveSession $liveSession, Floor $floor): MapContextLiveSession
    {
        return new MapContextLiveSession(
            $this->cacheService,
            $this->coordinatesService,
            $this->overpulledEnemyService,
            $liveSession,
            $floor
        );
    }

    /**
     * @param Dungeon        $dungeon
     * @param Floor          $floor
     * @param MappingVersion $mappingVersion
     *
     * @return MapContextDungeonExplore
     */
    public function createMapContextDungeonExplore(Dungeon $dungeon, Floor $floor, MappingVersion $mappingVersion): MapContextDungeonExplore
    {
        return new MapContextDungeonExplore(
            $this->cacheService,
            $this->coordinatesService,
            $dungeon,
            $floor,
            $mappingVersion
        );
    }

    /**
     * @param Dungeon        $dungeon
     * @param Floor          $floor
     * @param MappingVersion $mappingVersion
     *
     * @return MapContextMappingVersionEdit
     */
    public function createMapContextMappingVersionEdit(Dungeon $dungeon, Floor $floor, MappingVersion $mappingVersion): MapContextMappingVersionEdit
    {
        return new MapContextMappingVersionEdit(
            $this->cacheService,
            $this->coordinatesService,
            $dungeon,
            $floor,
            $mappingVersion
        );
    }


}
