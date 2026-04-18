<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function view(User $user, Team $team): bool
    {
        return $user->teams()->where('team_id', $team->id)->exists();
    }

    public function update(User $user, Team $team): bool
    {
        return $user->teams()->where('team_id', $team->id)->wherePivot('role', 'admin')->exists() ||
               $team->owner_id === $user->id;
    }

    public function delete(User $user, Team $team): bool
    {
        return $team->owner_id === $user->id;
    }

    public function inviteMember(User $user, Team $team): bool
    {
        return $user->teams()->where('team_id', $team->id)->wherePivot('role', 'admin')->exists() ||
               $team->owner_id === $user->id;
    }

    public function removeMember(User $user, Team $team, User $member): bool
    {
        // No puedes eliminarte a ti mismo
        if ($member->id === $user->id) {
            return false;
        }

        // Owner puede eliminar a cualquiera
        if ($team->owner_id === $user->id) {
            return true;
        }

        // Admin puede eliminar miembros (no otros admins)
        return $user->teams()->where('team_id', $team->id)->wherePivot('role', 'admin')->exists() &&
               $member->teams()->where('team_id', $team->id)->wherePivot('role', '!=', 'admin')->exists();
    }
}
