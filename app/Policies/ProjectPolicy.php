<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function view(User $user, Project $project): bool
    {
        return $user->currentTeam && $user->currentTeam->id === $project->team_id;
    }

    public function create(User $user): bool
    {
        return $user->currentTeam !== null;
    }

    public function update(User $user, Project $project): bool
    {
        return $user->currentTeam && $user->currentTeam->id === $project->team_id;
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->currentTeam &&
               $user->currentTeam->id === $project->team_id &&
               $user->currentTeam->owner_id === $user->id;
    }

    public function archive(User $user, Project $project): bool
    {
        return $user->currentTeam &&
               $user->currentTeam->id === $project->team_id &&
               ($user->currentTeam->owner_id === $user->id ||
                $user->teams()->where('team_id', $user->currentTeam->id)->wherePivot('role', 'admin')->exists());
    }
}
