<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return $user->currentTeam &&
               $user->currentTeam->id === $task->column->board->project->team_id;
    }

    public function create(User $user): bool
    {
        return $user->currentTeam !== null;
    }

    public function update(User $user, Task $task): bool
    {
        return $user->currentTeam &&
               $user->currentTeam->id === $task->column->board->project->team_id;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->currentTeam &&
               $user->currentTeam->id === $task->column->board->project->team_id &&
               ($task->created_by === $user->id ||
                $user->teams()->where('team_id', $user->currentTeam->id)->wherePivot('role', 'admin')->exists() ||
                $user->currentTeam->owner_id === $user->id);
    }
}
