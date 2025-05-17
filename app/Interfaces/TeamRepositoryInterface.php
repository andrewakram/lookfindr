<?php

namespace App\Interfaces;

use App\Models\Team;

interface TeamRepositoryInterface{

    public function createTeam(array $data);

    public function createTeamMember($teamId,array $data);

}
