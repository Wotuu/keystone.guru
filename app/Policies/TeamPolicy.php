<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\TeamUser;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can edit a team.
     *
     * @return bool
     */
    public function edit(User $user, Team $team): bool
    {
        // Everyone can view dungeon routes (for now)
        return $team->isUserMember($user);
    }

    /**
     * Determine whether the user can delete a team or not.
     *
     * @return bool
     */
    public function delete(User $user, Team $team): bool
    {
        return $team->isUserMember($user) && $team->getUserRole($user) === TeamUser::ROLE_ADMIN;
    }

    /**
     * @return boolean
     */
    public function moderateRoute(User $user, Team $team): bool
    {
        return $team->canAddRemoveRoute($user);
    }

    /**
     * @return boolean
     */
    public function changeRole(User $user, Team $team): bool
    {
        return $team->isUserModerator($user);
    }

    /**
     * @return boolean
     */
    public function changeDefaultRole(User $user, Team $team): bool
    {
        return $team->getUserRole($user) === TeamUser::ROLE_ADMIN;
    }

    /**
     * @return boolean
     */
    public function removeMember(User $user, Team $team, User $member): bool
    {
        return $team->canRemoveMember($user, $member);
    }

    /**
     * @return bool
     */
    public function refreshInviteLink(User $user, Team $team): bool
    {
        return $team->isUserModerator($user);
    }

    /**
     * Determine whether the user can perform ad-free giveaways on a member of a team.
     *
     * @return bool
     */
    public function canAdFreeGiveaway(User $user, Team $team): bool
    {
        // Everyone can view dungeon routes (for now)
        return $team->isUserMember($user);
    }
}
