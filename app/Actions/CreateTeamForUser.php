<?php

namespace App\Actions;

use App\Models\Plan;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Str;

class CreateTeamForUser
{
    public function execute(User $user): Team
    {
        $freePlan = Plan::where('slug', 'free')->firstOrFail();

        $team = Team::create([
            'name' => $user->name . "'s Team",
            'slug' => Str::slug($user->name . '-' . $user->id),
            'owner_id' => $user->id,
            'plan_id' => $freePlan->id,
        ]);

        $team->members()->attach($user->id, ['role' => 'owner']);

        $user->update(['current_team_id' => $team->id]);

        return $team;
    }
}
