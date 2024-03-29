<?php

namespace App\Models\Patreon;

use App\Models\Traits\SeederModel;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $name
 * @property string $key
 *
 * @mixin Eloquent
 *
 * @todo Using CacheModel causes cache problems? People did not get their patreon rewards applied properly because of it?
 */
class PatreonBenefit extends Model
{
    use SeederModel;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'key',
    ];

    protected $hidden = ['pivot'];

    public const AD_FREE = 'ad-free';

    public const UNLIMITED_DUNGEONROUTES = 'unlimited-dungeonroutes';

    public const UNLISTED_ROUTES = 'unlisted-routes';

    public const ANIMATED_POLYLINES = 'animated-polylines';

    public const ADVANCED_SIMULATION = 'advanced-simulation';

    public const AD_FREE_TEAM_MEMBERS = 'ad-free-team-members';

    public const ALL = [
        self::AD_FREE              => 1,
        //        self::UNLIMITED_DUNGEONROUTES => 2, // This was removed - it's now active for everyone
        self::UNLISTED_ROUTES      => 3,
        self::ANIMATED_POLYLINES   => 4,
        self::ADVANCED_SIMULATION  => 5,
        self::AD_FREE_TEAM_MEMBERS => 6,
    ];
}
