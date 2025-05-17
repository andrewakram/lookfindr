<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;

class ProjectPolicy
{
    public function view(User $user, Project $project): bool
    {
        return $user->teams()->where('teams.id', $project->team_id)->exists();
    }

    public function create(User $user, Team $team): bool
    {
        return $user->teams()->where('teams.id', $team->id)->exists();
    }
}
