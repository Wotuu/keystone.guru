<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property string $short
 * @property string $name
 * @property int $reset_day_offset ISO-8601 numeric representation of the day of the week
 * @property string $reset_hours_offset
 *
 * @property \Illuminate\Support\Collection $users
 *
 * @mixin \Eloquent
 */
class GameServerRegion extends Model
{
    protected $fillable = ['short', 'name', 'reset_day_offset', 'reset_hours_offset'];
    public $timestamps = false;

    private static $cachedDefaultRegion = null;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * @return GameServerRegion Gets the default region.
     */
    public static function getUserOrDefaultRegion(): GameServerRegion
    {
        if (self::$cachedDefaultRegion === null) {
            if (Auth::check()) {
                self::$cachedDefaultRegion = Auth::user()->gameserverregion;
            }

            if (self::$cachedDefaultRegion === null) {
                self::$cachedDefaultRegion = GameServerRegion::where('short', 'us')->first();
            }
        }
        return self::$cachedDefaultRegion;
    }

    public static function boot()
    {
        parent::boot();

        // This model may NOT be deleted, it's read only!
        static::deleting(function ($someModel)
        {
            return false;
        });
    }
}
