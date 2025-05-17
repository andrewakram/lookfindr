<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use App\Models\TeamMember;

class TeamRepository implements TeamRepositoryInterface {

    public function createTeam(array $data)
    {
        $team = Team::create($data);

        $this->createTeamMember($team->id,[]);

        return $team;
    }

    public function createTeamMember($teamId,$data)
    {
        $user = auth()->user();

        return TeamMember::create([
            'user_id'   => empty($data) ? $user->id : $data['member_id'],
            'team_id'   => $teamId,
            'role'      => empty($data) ? ($user->active ? 'owner' : 'member') : $data['role'],
        ]);

    }

}
