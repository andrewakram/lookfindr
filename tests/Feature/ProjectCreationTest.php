<?php

namespace Tests\Feature;

use App\Models\TeamMember;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_project_for_team()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        TeamMember::create([
            'role' => 'owner',
            'user_id' => $user->id,
            'team_id' => $team->id
        ]);

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson(route('teams.addProject', ['id' => $team->id]), [
            'name' => 'New Project',
            'description' => 'Project description',
            'status' => 'active',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('projects', ['name' => 'New Project', 'team_id' => $team->id]);
    }

    public function test_non_team_member_cannot_create_project()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        // Do NOT attach user to team

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson(route('teams.addProject', ['id' => $team->id]), [
            'name' => 'New Project',
            'description' => 'Project description',
            'status' => 'active',
        ]);

        $response->assertStatus(403);
    }
}
