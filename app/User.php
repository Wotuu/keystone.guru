<?php

namespace App;

use App\Email\CustomPasswordResetEmail;
use App\Models\DungeonRoute;
use App\Models\GameServerRegion;
use App\Models\PaidTier;
use App\Models\PatreonData;
use App\Models\Tags\Tag;
use App\Models\Tags\TagCategory;
use App\Models\Team;
use App\Models\Traits\HasIconFile;
use App\Models\UserReport;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * @property int $id
 * @property int $game_server_region_id
 * @property string $timezone
 * @property string $name
 * @property string $initials The initials (two letters) of a user so we can display it as the connected user in case of no avatar
 * @property string $email
 * @property string $theme
 * @property string $echo_color
 * @property boolean $echo_anonymous
 * @property string $password
 * @property boolean $legal_agreed
 * @property int $legal_agreed_ms
 * @property boolean $analytics_cookie_opt_out
 * @property boolean $changed_username
 * @property PatreonData $patreondata
 * @property GameServerRegion $gameserverregion
 *
 * @property boolean $is_admin
 *
 * @property DungeonRoute[]|Collection $dungeonroutes
 * @property UserReport[]|Collection $reports
 * @property Team[]|Collection $teams
 * @property Role[]|Collection $roles
 * @property Tag[]|Collection $tags
 *
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasIconFile;
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * @var string Have to specify connection explicitly so that Tracker still works (has its own DB)
     */
    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'oauth_id', 'game_server_region_id', 'name', 'email', 'echo_color', 'password', 'legal_agreed', 'legal_agreed_ms'
    ];

    /**
     * The attributes that should be visible for outsiders.
     *
     * @var array
     */
    protected $visible = [
        'id', 'name', 'echo_color'
    ];

    protected $appends = [
        'initials'
    ];

    protected $with = 'iconfile';

    /**
     * @return string
     */
    public function getInitialsAttribute(): string
    {
        return initials($this->name);
    }

    /**
     * @return bool
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * @return HasMany
     */
    public function dungeonroutes()
    {
        return $this->hasMany('App\Models\DungeonRoute', 'author_id');
    }

    /**
     * @return HasMany
     */
    public function reports()
    {
        return $this->hasMany('App\Models\UserReport');
    }

    /**
     * @return HasOne
     */
    public function patreondata()
    {
        return $this->hasOne('App\Models\PatreonData');
    }

    /**
     * @return BelongsTo
     */
    public function gameserverregion()
    {
        // Don't know why it won't work without the foreign key specified..
        return $this->belongsTo('App\Models\GameServerRegion', 'game_server_region_id');
    }

    /**
     * @return BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany('App\Models\Team', 'team_users');
    }

    /**
     * @param TagCategory|null $category
     * @return HasMany|Tag
     */
    public function tags(?TagCategory $category = null): HasMany
    {
        $result = $this->hasMany('\App\Models\Tags\Tag');

        if ($category !== null) {
            $result->where('tag_category_id', $category->id);
        }

        return $result;
    }

    /**
     * Checks if this user has registered using OAuth or not.
     *
     * @return bool
     */
    public function isOAuth(): bool
    {
        return empty($this->password);
    }

    /**
     * Checks if this user has paid for a certain tier one way or the other.
     *
     * @param $name
     * @return bool
     */
    function hasPaidTier($name): bool
    {
        // True for all admins
        $result = $this->hasRole('admin');

        // If we weren't an admin, check patreon data
        if (!$result && $this->patreondata !== null) {
            foreach ($this->patreondata->paidtiers as $tier) {
                if ($tier->name === $name) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Get a list of tiers that this User has access to.
     *
     * @return Collection
     */
    function getPaidTiers(): Collection
    {
        // Admins have all paid tiers
        if ($this->hasRole('admin')) {
            $result = PaidTier::all()->pluck(['name']);
        } else if (isset($this->patreondata)) {
            $result = $this->patreondata->paidtiers->pluck(['name']);
        } else {
            $result = collect();
        }

        return $result;
    }

    /**
     * Checks if this user can create a dungeon route or not (based on free account limits)
     */
    function canCreateDungeonRoute(): bool
    {
        return DungeonRoute::where('author_id', $this->id)->count() < config('keystoneguru.registered_user_dungeonroute_limit') ||
            $this->hasPaidTier(PaidTier::UNLIMITED_DUNGEONROUTES);
    }

    /**
     * Get the amount of routes a user may still create.
     *
     * NOTE: Will be inaccurate if the user is a Patron. Just don't call this function then.
     * @return int
     */
    function getRemainingRouteCount(): int
    {
        return (int)max(0,
            config('keystoneguru.registered_user_dungeonroute_limit') - DungeonRoute::where('author_id', $this->id)->count()
        );
    }

    /**
     * Sends the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPasswordResetEmail($token));
    }

    /**
     * Gets a list of consequences that will happen when this user tries to delete their account.
     */
    public function getDeleteConsequences(): array
    {
        $teams = ['teams' => []];
        foreach ($this->teams as $team) {
            /** @var $team Team */
            $teams['teams'][$team->name] = [
                'result'    => $team->members->count() === 1 ? 'deleted' : 'new_owner',
                'new_owner' => $team->getNewAdminUponAdminAccountDeletion($this)
            ];
        }

        return array_merge($teams, [
            'patreon'       => [
                'unlinked' => $this->patreondata !== null
            ],
            'dungeonroutes' => [
                'delete_count' => ($this->dungeonroutes->count() - $this->dungeonroutes()->isSandbox()->count())
            ],
            'reports'       => [
                'delete_count' => ($this->reports()->where('status', 0)->count())
            ]
        ]);
    }

    public static function boot()
    {
        parent::boot();

        // Delete user properly if it gets deleted
        static::deleting(function ($item)
        {
            /** @var $item User */
            $item->dungeonroutes()->delete();
            $item->reports()->delete();

            $item->patreondata()->delete();

            foreach ($item->teams as $team) {
                /** @var $team Team */
                $newAdmin = $team->getNewAdminUponAdminAccountDeletion($item);
                if ($newAdmin !== null) {
                    // Appoint someone else admin
                    $team->changeRole(User::find($newAdmin->id), 'admin');
                    // Remove ourselves from the team
                    $team->removeMember($item);
                } else {
                    $team->delete();
                }
            }
            return true;
        });
    }
}
