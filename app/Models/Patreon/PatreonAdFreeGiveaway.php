<?php

namespace App\Models\Patreon;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int    $id
 * @property int    $giver_user_id
 * @property int    $receiver_user_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @mixin Eloquent
 */
class PatreonAdFreeGiveaway extends Model
{
    protected $fillable = ['giver_user_id', 'receiver_user_id'];

    public function giver(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'giver_user_id');
    }

    public function receiver(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'receiver_user_id');
    }

    public static function getCountLeft(User $user): int
    {
        return $user->hasPatreonBenefit(PatreonBenefit::AD_FREE_TEAM_MEMBERS) ?
            max(0, config('keystoneguru.patreon.ad_free_giveaways') - PatreonAdFreeGiveaway::where('giver_user_id', $user->id)->count()) :
            0;
    }
}
