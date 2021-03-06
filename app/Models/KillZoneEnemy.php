<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id int
 * @property $kill_zone_id int
 * @property $enemy_id int
 *
 * @property KillZone $killzone
 * @property Enemy $enemy
 *
 * @mixin \Eloquent
 */
class KillZoneEnemy extends Model
{
    public $hidden = ['id', 'kill_zone_id'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function killzone()
    {
        return $this->belongsTo('App\Models\KillZone');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enemy()
    {
        return $this->belongsTo('App\Models\Enemy');
    }
}
