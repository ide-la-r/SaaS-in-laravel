<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        // Verify team been created
        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user->currentTeam);
        $this->assertTrue($user->currentTeam->owner_id === $user->id);

        // Verify plan assigned (Free)
        $plan = $user->currentTeam->plan;
        $this->assertNotNull($plan);
        $this->assertEquals('Free', $plan->name);
    }

    public function test_registered_user_has_free_plan(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->for($user, 'owner')->create(['plan_id' => Plan::where('slug', 'free')->first()->id]);
        $user->update(['current_team_id' => $team->id]);

        $this->assertTrue($user->currentTeam->plan->slug === 'free');
        $this->assertTrue($user->currentTeam->plan->max_projects === 3);
    }
}
