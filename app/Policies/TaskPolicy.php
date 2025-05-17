<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return $user->teams()->whereHas('projects', function ($q) use ($task) {
            $q->where('projects.id', $task->project_id);
        })->exists();
    }

    public function create(User $user, Project $project): bool
    {
        return $user->teams()->where('teams.id', $project->team_id)->exists();
    }

    public function assign(User $user, Task $task): bool
    {
        return $user->teams()
            ->whereHas('projects', function ($q) use ($task) {
                $q->where('projects.id', $task->project_id)
                    ->whereColumn('projects.team_id', 'teams.id');
            })
            ->where('team_members.role', 'owner')
            ->exists();
    }
}
