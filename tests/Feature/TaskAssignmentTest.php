<?php

namespace Tests\Feature;

use App\Models\TeamMember;
use App\Models\User;
use App\Models\Team;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_owner_can_assign_task()
    {
        $owner = User::factory()->create();
        $member = User::factory()->create();

        $team = Team::factory()->create();
        TeamMember::create([
            'role' => 'owner',
            'user_id' => $owner->id,
            'team_id' => $team->id
        ]);
        TeamMember::create([
            'role' => 'member',
            'user_id' => $member->id,
            'team_id' => $team->id
        ]);

        $project = Project::factory()->create(['team_id' => $team->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        $this->actingAs($owner, 'sanctum');

        $response = $this->putJson("/api/tasks/{$task->id}/assign", [
            'member_id' => $member->id,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'user_id' => $member->id,
        ]);
    }

    public function test_non_owner_cannot_assign_task()
    {
        $member = User::factory()->create();
        $team = Team::factory()->create();

        TeamMember::create([
            'role' => 'member',
            'user_id' => $member->id,
            'team_id' => $team->id
        ]);

        $project = Project::factory()->create(['team_id' => $team->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        $this->actingAs($member, 'sanctum');

        $response = $this->putJson("/api/tasks/{$task->id}/assign", [
            'member_id' => $member->id,
        ]);

        $response->assertForbidden();
    }
}

