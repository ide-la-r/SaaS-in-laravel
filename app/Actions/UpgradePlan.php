<?php

namespace App\Actions;

use App\Models\ActivityLog;
use App\Models\Plan;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UpgradePlan
{
    public function execute(Team $team, Plan $newPlan): Team
    {
        Gate::authorize('update', $team);
        $oldPlan = $team->plan;

        // If Stripe price is set, handle subscription
        if ($newPlan->stripe_price_id) {
            $subscription = $team->subscription('default');

            if ($subscription) {
                $subscription->swap($newPlan->stripe_price_id);
            } else {
                // Will be implemented with checkout flow in Sprint 3
            }
        }

        $team->update(['plan_id' => $newPlan->id]);

        ActivityLog::create([
            'team_id' => $team->id,
            'user_id' => Auth::id(),
            'subject_type' => Team::class,
            'subject_id' => $team->id,
            'action' => 'plan_upgraded',
            'properties' => [
                'from' => $oldPlan?->name,
                'to' => $newPlan->name,
            ],
        ]);

        return $team->fresh();
    }
}
