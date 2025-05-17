<?php

namespace App\Http\Controllers;

use App\Http\Requests\Team\CreateTeamMemberRequest;
use App\Http\Requests\Team\CreateTeamRequest;
use App\Http\Resources\Team\TeamMemberResource;
use App\Http\Resources\Team\TeamResource;
use App\Interfaces\TeamRepositoryInterface;
use App\Services\TeamService;
use App\Traits\ApiResponserTrait;

class TeamController extends Controller
{
    use ApiResponserTrait;

    private TeamService $teamService;
    private TeamRepositoryInterface $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->teamService = new TeamService($this->teamRepository);
    }

    public function store(CreateTeamRequest $request)
    {
        return $this->successResponse(new TeamResource($this->teamService->create($request)));
    }

    public function addMember($teamId,CreateTeamMemberRequest $request)
    {
        return $this->successResponse(new TeamMemberResource($this->teamService->createTeamMember($teamId,$request)));
    }
}
