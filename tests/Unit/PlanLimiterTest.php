<?php

namespace Tests\Unit;

use App\Exceptions\PlanLimitExceededException;
use App\Models\Plan;
use App\Models\Team;
use App\Models\User;
use App\Services\PlanLimiter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanLimiterTest extends TestCase
{
    use RefreshDatabase;

    public function test_plan_limiter_throws_on_limit_exceeded(): void
    {
        $user = User::factory()->create();
        $freePlan = Plan::where('slug', 'free')->first();
        $team = Team::factory()->for($user, 'owner')->create(['plan_id' => $freePlan->id]);

        $this->expectException(PlanLimitExceededException::class);
        PlanLimiter::check($team, 'max_projects');
    }

    public function test_plan_limiter_passes_when_not_at_limit(): void
    {
        $user = User::factory()->create();
        $freePlan = Plan::where('slug', 'free')->first();
        $team = Team::factory()->for($user, 'owner')->create(['plan_id' => $freePlan->id]);

        // Should not throw
        PlanLimiter::check($team, 'max_projects');
        $this->assertTrue(true);
    }

    public function test_plan_limiter_unlimited_always_passes(): void
    {
        $user = User::factory()->create();
        $businessPlan = Plan::where('slug', 'business')->first();
        $team = Team::factory()->for($user, 'owner')->create(['plan_id' => $businessPlan->id]);

        // -1 means unlimited
        PlanLimiter::check($team, 'max_projects');
        $this->assertTrue(true);
    }
}
