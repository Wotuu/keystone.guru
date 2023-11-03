<?php

namespace App\Logic\MapContext;

use App\Http\Controllers\Traits\ListsEnemies;
use App\Models\CharacterClass;
use App\Models\Dungeon;
use App\Models\Faction;
use App\Models\Floor\Floor;
use App\Models\MapIconType;
use App\Models\Mapping\MappingVersion;
use App\Models\PublishedState;
use App\Models\RaidMarker;
use App\Models\Spell;
use App\Service\Cache\CacheServiceInterface;
use App\Service\Coordinates\CoordinatesServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Psr\SimpleCache\InvalidArgumentException;

abstract class MapContext
{
    use ListsEnemies;

    protected CacheServiceInterface $cacheService;

    protected CoordinatesServiceInterface $coordinatesService;

    protected Model $context;

    protected Floor $floor;

    protected MappingVersion $mappingVersion;

    function __construct(
        CacheServiceInterface       $cacheService,
        CoordinatesServiceInterface $coordinatesService,
        Model                       $context,
        Floor                       $floor,
        MappingVersion              $mappingVersion
    )
    {
        $this->cacheService       = $cacheService;
        $this->coordinatesService = $coordinatesService;
        $this->context            = $context;
        $this->floor              = $floor;
        $this->mappingVersion     = $mappingVersion;
    }

    public abstract function getType(): string;

    public abstract function isTeeming(): bool;

    public abstract function getSeasonalIndex(): int;

    public abstract function getEnemies(): array;

    public abstract function getEchoChannelName(): string;

    public abstract function getMapFacadeStyle(): string;

    /**
     * @return Model
     */
    public function getContext(): Model
    {
        return $this->context;
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function getProperties(): array
    {
        $mapFacadeStyle = $this->getMapFacadeStyle();

        // Get the DungeonData
        $dungeonData = $this->cacheService->remember(
            sprintf('dungeon_%d_%d_%s', $this->floor->dungeon->id, $this->mappingVersion->id, $mapFacadeStyle),
            function () use ($mapFacadeStyle) {
                $useFacade = $mapFacadeStyle === 'facade';

                /** @var Dungeon $dungeon */
                $dungeon = $this->floor->dungeon()->without(['floors', 'mapicons', 'enemypacks'])->first();
                // Filter out floors that we do not need
                $dungeon->setRelation('floors', $dungeon->floorsForMapFacade($useFacade)->get());

                return array_merge($dungeon->toArray(), $this->getEnemies(), [
                    'latestMappingVersion'      => $this->floor->dungeon->getCurrentMappingVersion(),
                    'npcs'                      => $this->floor->dungeon->npcs()->with([
                        'spells',
                        // Restrain the enemy forces relationship so that it returns the enemy forces of the target mapping version only
                        'enemyForces' => function (HasOne $query) {
                            return $query->where('mapping_version_id', $this->mappingVersion->id);
                        },
                    ])->get(),
                    'auras'                     => Spell::where('aura', true)->get(),
                    'enemies'                   => $this->mappingVersion->mapContextEnemies($this->coordinatesService, $useFacade),
                    'enemyPacks'                => $this->mappingVersion->mapContextEnemyPacks($this->coordinatesService, $useFacade),
                    'enemyPatrols'              => $this->mappingVersion->mapContextEnemyPatrols($this->coordinatesService, $useFacade),
                    'mapIcons'                  => $this->mappingVersion->mapContextMapIcons($this->coordinatesService, $useFacade),
                    'dungeonFloorSwitchMarkers' => $this->mappingVersion->mapContextDungeonFloorSwitchMarkers($this->coordinatesService, $useFacade),
                    'mountableAreas'            => $this->mappingVersion->mapContextMountableAreas($this->coordinatesService, $useFacade),
                    'floorUnions'               => $this->mappingVersion->mapContextFloorUnions($this->coordinatesService, $useFacade),
                    'floorUnionAreas'           => $this->mappingVersion->mapContextFloorUnionAreas($this->coordinatesService, $useFacade),
                ]);
            }, config('keystoneguru.cache.dungeonData.ttl'));

        $static = $this->cacheService->remember('static_data', function () {
            return [
                'spells'                            => Spell::all(),
                'mapIconTypes'                      => MapIconType::all(),
                'unknownMapIconType'                => MapIconType::find(MapIconType::ALL[MapIconType::MAP_ICON_TYPE_UNKNOWN]),
                'awakenedObeliskGatewayMapIconType' => MapIconType::find(MapIconType::ALL[MapIconType::MAP_ICON_TYPE_GATEWAY]),
                'classColors'                       => CharacterClass::all()->pluck('color'),
                'raidMarkers'                       => RaidMarker::all(),
                'factions'                          => Faction::where('name', '<>', 'Unspecified')->with('iconfile')->get(),
                'publishStates'                     => PublishedState::all(),
            ];
        }, config('keystoneguru.cache.static_data.ttl'));

        $npcMinHealth = $this->floor->dungeon->getNpcsMinHealth($this->mappingVersion);
        $npcMaxHealth = $this->floor->dungeon->getNpcsMaxHealth($this->mappingVersion);

        // Prevent the values being exactly the same, which causes issues in the front end
        if ($npcMaxHealth <= $npcMinHealth) {
            $npcMaxHealth = $npcMinHealth + 1;
        }

        return [
            'type'                => $this->getType(),
            'mappingVersion'      => $this->mappingVersion,
            'floorId'             => $this->floor->id,
            'teeming'             => $this->isTeeming(),
            'seasonalIndex'       => $this->getSeasonalIndex(),
            'dungeon'             => $dungeonData,
            'static'              => $static,
            'minEnemySizeDefault' => config('keystoneguru.min_enemy_size_default'),
            'maxEnemySizeDefault' => config('keystoneguru.max_enemy_size_default'),
            'npcsMinHealth'       => $npcMinHealth,
            'npcsMaxHealth'       => $npcMaxHealth,

            'keystoneScalingFactor' => config('keystoneguru.keystone.scaling_factor'),

            'echoChannelName' => $this->getEchoChannelName(),
            // May be null
            'userPublicKey'   => optional(Auth::user())->public_key,
        ];
    }
}
