<?php

namespace Tests\Feature;

use App\Actions\CreateProject;
use App\Exceptions\PlanLimitExceededException;
use App\Models\Plan;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanLimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_free_plan_limits_to_3_projects(): void
    {
        $user = User::factory()->create();
        $freePlan = Plan::where('slug', 'free')->first();
        $team = Team::factory()->for($user, 'owner')->create(['plan_id' => $freePlan->id]);
        $user->update(['current_team_id' => $team->id]);

        // Create 3 projects (should succeed)
        for ($i = 0; $i < 3; $i++) {
            Project::factory()->for($team)->create(['created_by' => $user->id]);
        }

        $this->assertEquals(3, $team->projects()->count());

        // Try to create 4th project (should fail)
        $this->expectException(PlanLimitExceededException::class);

        app(CreateProject::class)->execute($team, [
            'name' => 'Fourth Project',
            'description' => 'This should fail',
        ]);
    }

    public function test_pro_plan_allows_20_projects(): void
    {
        $user = User::factory()->create();
        $proPlan = Plan::where('slug', 'pro')->first();
        $team = Team::factory()->for($user, 'owner')->create(['plan_id' => $proPlan->id]);
        $user->update(['current_team_id' => $team->id]);

        for ($i = 0; $i < 20; $i++) {
            app(CreateProject::class)->execute($team, [
                'name' => 'Project ' . ($i + 1),
            ]);
        }

        $this->assertEquals(20, $team->projects()->count());

        // 21st should fail
        $this->expectException(PlanLimitExceededException::class);
        app(CreateProject::class)->execute($team, ['name' => 'Project 21']);
    }

    public function test_business_plan_unlimited(): void
    {
        $user = User::factory()->create();
        $businessPlan = Plan::where('slug', 'business')->first();
        $team = Team::factory()->for($user, 'owner')->create(['plan_id' => $businessPlan->id]);
        $user->update(['current_team_id' => $team->id]);

        // Create 50 projects (should all succeed)
        for ($i = 0; $i < 50; $i++) {
            app(CreateProject::class)->execute($team, [
                'name' => 'Project ' . ($i + 1),
            ]);
        }

        $this->assertEquals(50, $team->projects()->count());
    }
}
