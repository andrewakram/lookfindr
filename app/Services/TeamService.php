<?php

namespace App\Services;

use App\Http\Requests\Team\CreateTeamMemberRequest;
use App\Http\Requests\Team\CreateTeamRequest;
use App\Interfaces\TeamRepositoryInterface;

class TeamService{

    private TeamRepositoryInterface $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function create(CreateTeamRequest $request)
    {
        return $this->teamRepository->createTeam($request->validated());
    }

    public function createTeamMember($teamId,CreateTeamMemberRequest $request)
    {
        return $this->teamRepository->createTeamMember($teamId,$request->validated());
    }

}
