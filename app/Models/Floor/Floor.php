<?php

namespace App\Models\Floor;

use App\Logic\Structs\LatLng;
use App\Models\CacheModel;
use App\Models\Dungeon;
use App\Models\DungeonFloorSwitchMarker;
use App\Models\Enemy;
use App\Models\EnemyPack;
use App\Models\EnemyPatrol;
use App\Models\MapIcon;
use App\Models\Mapping\MappingModelInterface;
use App\Models\Mapping\MappingVersion;
use App\Models\MountableArea;
use App\Models\Speedrun\DungeonSpeedrunRequiredNpc;
use App\Models\Traits\HasLatLng;
use App\Models\Traits\SeederModel;
use App\Service\Coordinates\CoordinatesServiceInterface;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int                                     $id
 * @property int                                     $dungeon_id
 * @property int                                     $index
 * @property int|null                                $mdt_sub_level
 * @property int|null                                $ui_map_id
 * @property string                                  $name
 * @property bool                                    $default
 * @property bool                                    $facade
 * @property int                                     $min_enemy_size
 * @property int                                     $max_enemy_size
 * @property int                                     $enemy_engagement_max_range When generating dungeon routes, this is the maximum range from engagement of an enemy where we consider enemies in the mapping to match up
 * @property int                                     $enemy_engagement_max_range_patrols The max range after which we're considering patrols
 * @property float                                   $ingame_min_x
 * @property float                                   $ingame_min_y
 * @property float                                   $ingame_max_x
 * @property float                                   $ingame_max_y
 * @property int|null                                $percentage_display_zoom
 * @property bool                                    $active
 * @property Dungeon                                 $dungeon
 * @property FloorUnion|null                         $floorUnion
 * @property Collection|Enemy[]                      $enemies
 * @property Collection|EnemyPack[]                  $enemypacks
 * @property Collection|EnemyPatrol[]                $enemypatrols
 * @property Collection|MapIcon[]                    $mapIcons
 * @property Collection|DungeonFloorSwitchMarker[]   $dungeonFloorSwitchMarkers
 * @property Collection|MountableArea[]              $mountableareas
 * @property Collection|FloorUnion[]                 $floorUnions
 * @property Collection|FloorUnionArea[]             $floorUnionAreas
 * @property Collection|Enemy[]                      $enemiesForExport
 * @property Collection|EnemyPack[]                  $enemyPacksForExport
 * @property Collection|EnemyPatrol[]                $enemyPatrolsForExport
 * @property Collection|MapIcon[]                    $mapIconsForExport
 * @property Collection|DungeonFloorSwitchMarker[]   $dungeonFloorSwitchMarkersForExport
 * @property Collection|MountableArea[]              $mountableAreasForExport
 * @property Collection|FloorUnion[]                 $floorUnionsForExport
 * @property Collection|FloorUnionArea[]             $floorUnionAreasForExport
 * @property Collection|FloorCoupling[]              $floorcouplings
 * @property Collection|DungeonSpeedrunRequiredNpc[] $dungeonspeedrunrequirednpcs
 * @property Collection|Floor[]                      $connectedFloors
 * @property Collection|Floor[]                      $directConnectedFloors
 * @property Collection|Floor[]                      $reverseConnectedFloors
 *
 * @method static Builder active()
 * @method static Builder indexOrFacade(int $floorIndex)
 * @method static Builder defaultOrFacade()
 *
 * @mixin Eloquent
 */
class Floor extends CacheModel implements MappingModelInterface
{
    use HasFactory;
    use HasLatLng;
    use SeederModel;

    // Can map certain floors to others here, so that we can put enemies that are on their own floor (like some final
    // bosses) and put them on the main floor without introducing a 2nd floor.
    public const UI_MAP_ID_MAPPING = [
        // Court of Stars
        762  => 761,
        763  => 761,
        // Brackenhide Hollow
        2106 => 2096,
        // Temple of the Jade Serpent
        430  => 429,
        // Algeth'ar Academy
        2099 => 2097,
        // Ruby Life Pools (Dragon Isles zone)
        1978 => 2095,
        // Nokhud Offensive
        2023 => 2093,
    ];

    protected $fillable = [
        'dungeon_id',
        'index',
        'name',
        'default',
        'facade',
        'ui_map_id',
        'enemy_engagement_max_range',
        'enemy_engagement_max_range_patrols',
        'ingame_min_x',
        'ingame_min_y',
        'ingame_max_x',
        'ingame_max_y',
        'active',
    ];

    public $timestamps = false;

    public $hidden = ['dungeon', 'dungeon_id', 'created_at', 'updated_at'];

    public function dungeon(): BelongsTo
    {
        return $this->belongsTo(Dungeon::class);
    }

    public function enemies(?MappingVersion $mappingVersion = null): HasMany
    {
        return $this->hasMany(Enemy::class)
            ->where('enemies.mapping_version_id', ($mappingVersion ?? $this->dungeon->currentMappingVersion)->id);
    }

    public function enemypacks(?MappingVersion $mappingVersion = null): HasMany
    {
        return $this->hasMany(EnemyPack::class)
            ->where('enemy_packs.mapping_version_id', ($mappingVersion ?? $this->dungeon->currentMappingVersion)->id);
    }

    public function enemypatrols(?MappingVersion $mappingVersion = null): HasMany
    {
        return $this->hasMany(EnemyPatrol::class)
            ->where('enemy_patrols.mapping_version_id', ($mappingVersion ?? $this->dungeon->currentMappingVersion)->id);
    }

    public function mapIcons(?MappingVersion $mappingVersion = null): HasMany
    {
        return $this->hasMany(MapIcon::class)->whereNull('dungeon_route_id')
            ->where('map_icons.mapping_version_id', ($mappingVersion ?? $this->dungeon->currentMappingVersion)->id);
    }

    public function mountableAreas(?MappingVersion $mappingVersion = null): HasMany
    {
        return $this->hasMany(MountableArea::class)
            ->where('mountable_areas.mapping_version_id', ($mappingVersion ?? $this->dungeon->currentMappingVersion)->id);
    }

    public function dungeonFloorSwitchMarkers(?MappingVersion $mappingVersion = null): HasMany
    {
        return $this->hasMany(DungeonFloorSwitchMarker::class)
            ->where('mapping_version_id', ($mappingVersion ?? $this->dungeon->currentMappingVersion)->id);
    }

    public function enemiesForExport(): HasMany
    {
        return $this->hasMany(Enemy::class);
    }

    public function enemyPacksForExport(): HasMany
    {
        return $this->hasMany(EnemyPack::class);
    }

    public function enemyPatrolsForExport(): HasMany
    {
        return $this->hasMany(EnemyPatrol::class);
    }

    public function mapIconsForExport(): HasMany
    {
        return $this->hasMany(MapIcon::class)->where('dungeon_route_id', null);
    }

    public function mountableAreasForExport(): HasMany
    {
        return $this->hasMany(MountableArea::class);
    }

    public function floorUnionsForExport(): HasMany
    {
        return $this->hasMany(FloorUnion::class);
    }

    public function floorUnionAreasForExport(): HasMany
    {
        return $this->hasMany(FloorUnionArea::class);
    }

    public function dungeonFloorSwitchMarkersForExport(): HasMany
    {
        return $this->hasMany(DungeonFloorSwitchMarker::class);
    }

    public function floorcouplings(): HasMany
    {
        return $this->hasMany(FloorCoupling::class, 'floor1_id');
    }

    public function floorUnions(): HasMany
    {
        return $this->hasMany(FloorUnion::class);
    }

    public function floorUnionAreas(): HasMany
    {
        return $this->hasMany(FloorUnionArea::class);
    }

    /**
     * If this floor is in a union to another floor (this floor will not contain enemies and delegates it to this other floor instead)
     */
    public function floorUnion(): HasOne
    {
        return $this->hasOne(FloorUnion::class, 'target_floor_id');
    }

    /**
     * @return Collection|Floor[] A list of all connected floors, regardless of direction
     */
    public function connectedFloors(): Collection
    {
        return $this->directConnectedFloors->merge($this->reverseConnectedFloors);
    }

    public function directConnectedFloors(): BelongsToMany
    {
        return $this->belongsToMany(Floor::class, 'floor_couplings', 'floor1_id', 'floor2_id');
    }

    public function reverseConnectedFloors(): BelongsToMany
    {
        return $this->belongsToMany(Floor::class, 'floor_couplings', 'floor2_id', 'floor1_id');
    }

    public function dungeonSpeedrunRequiredNpcs10Man(): HasMany
    {
        return $this->hasMany(DungeonSpeedrunRequiredNpc::class)
            ->where('difficulty', Dungeon::DIFFICULTY_10_MAN);
    }

    public function dungeonSpeedrunRequiredNpcs25Man(): HasMany
    {
        return $this->hasMany(DungeonSpeedrunRequiredNpc::class)
            ->where('difficulty', Dungeon::DIFFICULTY_25_MAN);
    }

    /**
     * Scope a query to only include active floors.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('floors.active', 1);
    }

    public function scopeIndexOrFacade(Builder $builder, int $floorIndex, ?string $mapFacadeStyle = null): Builder
    {
        $useFacade = ($mapFacadeStyle ?? User::getCurrentUserMapFacadeStyle()) === User::MAP_FACADE_STYLE_FACADE;

        // Facade should be FORCED to use floor index 1
        if ($useFacade && $floorIndex > 1) {
            $floorIndex = 1;
        }

        // Either grab the facade floor, or grab the requested floor _as long as it's not the facade floor_, otherwise return the default floor
        return $builder->where(fn(Builder $builder) => $builder->when($useFacade, fn(Builder $builder) => $builder->where('facade', 1)
            ->orWhere('default', 1))->when(!$useFacade, fn(Builder $builder) => $builder->where('facade', 0)
            ->where(function (Builder $builder) use ($floorIndex) {
                // Either try to resolve the actual floor, or revert to the default if not found
                $builder->where('index', $floorIndex)
                    ->orWhere('default', 1);
            })))->orderByDesc($useFacade ? 'facade' : 'default')
            ->limit(1);
    }

    public function scopeDefaultOrFacade(Builder $builder): Builder
    {
        $useFacade = User::getCurrentUserMapFacadeStyle() === User::MAP_FACADE_STYLE_FACADE;

        return $builder->where(function (Builder $builder) {
            $builder->where('facade', 1)
                ->orWhere('default', 1);
        })->orderByDesc($useFacade ? 'facade' : 'default')
            ->limit(1);
    }

    public function findClosestFloorSwitchMarker(
        CoordinatesServiceInterface $coordinatesService,
        LatLng                      $latLng,
        int                         $targetFloorId): ?DungeonFloorSwitchMarker
    {
        $result = null;

        /** @var Collection|DungeonFloorSwitchMarker[] $dungeonFloorSwitchMarkers */
        $dungeonFloorSwitchMarkers = $this->dungeonFloorSwitchMarkers()
            ->where('target_floor_id', $targetFloorId)->get();

        if ($dungeonFloorSwitchMarkers->count() > 1) {
            // Find the closest floors switch marker with the same target floor
            $distanceToClosestFloorSwitchMarker = 99999999999;
            foreach ($dungeonFloorSwitchMarkers as $dungeonFloorSwitchMarker) {
                $distanceToFloorSwitchMarker = $coordinatesService->distanceBetweenPoints(
                    $latLng->getLng(), $dungeonFloorSwitchMarker->lng,
                    $latLng->getLat(), $dungeonFloorSwitchMarker->lat
                );

                if ($distanceToClosestFloorSwitchMarker > $distanceToFloorSwitchMarker) {
                    $distanceToClosestFloorSwitchMarker = $distanceToFloorSwitchMarker;
                    $result                             = $dungeonFloorSwitchMarker;
                }
            }
        } else {
            $result = $dungeonFloorSwitchMarkers->first();
        }

        return $result;
    }

    public function getDungeonId(): ?int
    {
        return $this->dungeon_id;
    }

    /**
     * @param int|null $dungeonId Can be passed in case the uiMapIds are not unique
     */
    public static function findByUiMapId(int $uiMapId, ?int $dungeonId = null): Floor
    {
        return Floor::where('ui_map_id', self::UI_MAP_ID_MAPPING[$uiMapId] ?? $uiMapId)
            ->when($dungeonId !== null, fn(Builder $builder) => $builder->where('dungeon_id', $dungeonId))
            ->firstOrFail();
    }

    public function ensureConnectionToFloor(Floor $targetFloor): bool
    {
        $hasCoupling = false;
        foreach ($this->floorcouplings as $floorCoupling) {
            if ($floorCoupling->floor2_id === $targetFloor->id) {
                $hasCoupling = true;
                break;
            }
        }

        if (!$hasCoupling) {
            FloorCoupling::create([
                'floor1_id' => $this->id,
                'floor2_id' => $targetFloor->id,
            ]);
        }

        return !$hasCoupling;
    }
}
