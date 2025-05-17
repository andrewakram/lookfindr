<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\ShowProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Interfaces\ProjectRepositoryInterface;
use App\Services\ProjectService;
use App\Traits\ApiResponserTrait;

class ProjectController extends Controller
{
    use ApiResponserTrait;

    private ProjectService $projectService;
    private ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->projectService = new ProjectService($this->projectRepository);
    }

    public function show($projectId,ShowProjectRequest $request)
    {
        $request->validated();

        return $this->successResponse(new ProjectResource($this->projectService->showProject($projectId)));
    }

    public function addProject($teamId,CreateProjectRequest $request)
    {
        return $this->successResponse(new ProjectResource($this->projectService->createProject($teamId,$request)));
    }
}
