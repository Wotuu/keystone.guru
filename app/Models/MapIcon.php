<?php

namespace App\Models;

use App\Models\Traits\HasLinkedAwakenedObelisk;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $mapping_version_id
 * @property int $floor_id
 * @property int $dungeon_route_id
 * @property int $team_id
 * @property int $map_icon_type_id
 * @property float $lat
 * @property float $lng
 * @property string $comment
 * @property boolean $permanent_tooltip
 * @property int $seasonal_index
 *
 * @property Floor $floor
 * @property DungeonRoute $dungeonroute
 * @property MapIconType $mapicontype
 *
 * @mixin Eloquent
 */
class MapIcon extends Model implements MappingModelInterface
{
    use HasLinkedAwakenedObelisk;

    protected $visible = ['id', 'mapping_version_id', 'floor_id', 'team_id', 'map_icon_type_id', 'linked_awakened_obelisk_id', 'is_admin', 'lat', 'lng', 'comment', 'permanent_tooltip', 'seasonal_index'];
    protected $fillable = ['floor_id', 'dungeon_route_id', 'team_id', 'map_icon_type_id', 'lat', 'lng', 'comment', 'permanent_tooltip'];
    protected $appends = ['linked_awakened_obelisk_id', 'is_admin'];

    protected $with = ['mapicontype', 'linkedawakenedobelisks'];

    /**
     * @return BelongsTo
     */
    function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * @return BelongsTo
     */
    function dungeonroute(): BelongsTo
    {
        return $this->belongsTo(DungeonRoute::class);
    }

    /**
     * @return BelongsTo
     */
    public function mapicontype(): BelongsTo
    {
        // Need the foreign key for some reason
        return $this->belongsTo(MapIconType::class, 'map_icon_type_id');
    }

    /**
     * @return bool
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->dungeon_route_id === -1;
    }

    /**
     * @return bool
     */
    public function isAwakenedObelisk(): bool
    {
        return $this->map_icon_type_id >= 17 && $this->map_icon_type_id <= 20;
    }

    /**
     * @return int
     */
    public function getDungeonId(): int
    {
        return $this->floor->dungeon_id;
    }
}
