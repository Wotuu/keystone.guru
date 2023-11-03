<?php

namespace App\Models\Floor;

use App\Models\CacheModel;
use App\Models\Mapping\MappingModelCloneableInterface;
use App\Models\Mapping\MappingModelInterface;
use App\Models\Mapping\MappingVersion;
use App\Models\Traits\HasLatLng;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int                         $id
 * @property int                         $mapping_version_id
 * @property int                         $floor_id
 * @property int                         $target_floor_id
 * @property float                       $lat
 * @property float                       $lng
 * @property float                       $size
 * @property float                       $rotation
 *
 * @property MappingVersion              $mappingVersion
 * @property Floor                       $floor
 * @property Floor                       $targetFloor
 *
 * @property Collection|FloorUnionArea[] $floorUnionAreas
 *
 * @mixin Eloquent
 */
class FloorUnion extends CacheModel implements MappingModelInterface, MappingModelCloneableInterface
{
    use HasLatLng;

    public $timestamps = false;

    protected $fillable = [
        'mapping_version_id',
        'floor_id',
        'target_floor_id',
        'lat',
        'lng',
        'size',
        'rotation',
    ];

    protected $with = [
        'floorUnionAreas',
    ];

    protected $hidden = ['floor'];

    protected $casts = [
        'mapping_version_id' => 'integer',
        'floor_id'           => 'integer',
        'target_floor_id'    => 'integer',
        'lat'                => 'float',
        'lng'                => 'float',
        'size'               => 'float',
        'rotation'           => 'float',
    ];

    /**
     * @return BelongsTo
     */
    public function mappingVersion(): BelongsTo
    {
        return $this->belongsTo(MappingVersion::class);
    }

    /**
     * @return BelongsTo
     */
    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * @return BelongsTo
     */
    public function targetFloor(): BelongsTo
    {
        return $this->belongsTo(Floor::class, 'target_floor_id');
    }

    /**
     * @return HasMany
     */
    public function floorUnionAreas(): HasMany
    {
        return $this->hasMany(FloorUnionArea::class);
    }

    /**
     * @return int|null
     */
    public function getDungeonId(): ?int
    {
        return $this->floor->dungeon_id;
    }

    /**
     * @param MappingVersion             $mappingVersion
     * @param MappingModelInterface|null $newParent
     *
     * @return FloorUnion
     */
    public function cloneForNewMappingVersion(MappingVersion $mappingVersion, ?MappingModelInterface $newParent = null): FloorUnion
    {
        /** @var FloorUnion|MappingModelInterface $clonedFloorUnion */
        $clonedFloorUnion                     = clone $this;
        $clonedFloorUnion->exists             = false;
        $clonedFloorUnion->id                 = null;
        $clonedFloorUnion->mapping_version_id = $mappingVersion->id;
        $clonedFloorUnion->save();

        foreach($this->floorUnionAreas as $floorUnionArea){
            $floorUnionArea->cloneForNewMappingVersion($mappingVersion, $clonedFloorUnion);
        }

        return $clonedFloorUnion;
    }
}
