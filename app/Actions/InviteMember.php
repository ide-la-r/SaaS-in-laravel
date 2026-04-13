<?php

namespace App\Actions;

use App\Models\ActivityLog;
use App\Models\Team;
use App\Models\User;
use App\Services\PlanLimiter;
use Illuminate\Support\Facades\Auth;

class InviteMember
{
    public function execute(Team $team, string $email, string $role = 'member'): User
    {
        PlanLimiter::check($team, 'max_members');

        $user = User::where('email', $email)->firstOrFail();

        $team->members()->syncWithoutDetaching([
            $user->id => ['role' => $role],
        ]);

        ActivityLog::create([
            'team_id' => $team->id,
            'user_id' => Auth::id(),
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'action' => 'invited',
            'properties' => ['email' => $email, 'role' => $role],
        ]);

        return $user;
    }
}
