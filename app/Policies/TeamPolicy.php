<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function isMember(User $user, Team $team): bool
    {
        return $team->members()->where('user_id', $user->id)->exists();
    }

    public function isOwner(User $user, Team $team): bool
    {
        return $team->members()->where('user_id', $user->id)->wherePivot('role', 'owner')->exists();
    }

    public function view(User $user, Team $team): bool
    {
        return $this->isMember($user, $team);
    }

    public function update(User $user, Team $team): bool
    {
        return $this->isOwner($user, $team);
    }

    public function create(User $user, Team $team): bool
    {
        return $team->members()->where('user_id', $user->id)->exists();
    }
}

