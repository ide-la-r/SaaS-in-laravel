<?php

namespace App\Services;

use App\Exceptions\PlanLimitExceededException;
use App\Models\Team;

class PlanLimiter
{
    public static function check(Team $team, string $feature): void
    {
        $plan = $team->plan;

        if (!$plan) {
            throw new PlanLimitExceededException($feature);
        }

        $limit = match ($feature) {
            'max_projects' => $plan->max_projects,
            'max_members' => $plan->max_members,
            default => -1,
        };

        // -1 means unlimited
        if ($limit === -1) {
            return;
        }

        $current = match ($feature) {
            'max_projects' => $team->projects()->count(),
            'max_members' => $team->members()->count(),
            default => 0,
        };

        if ($current >= $limit) {
            throw new PlanLimitExceededException($feature, $limit);
        }
    }
}
