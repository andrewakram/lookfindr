<?php

namespace App\Services;

use App\Http\Requests\Project\CreateProjectRequest;
use App\Interfaces\ProjectRepositoryInterface;

class ProjectService{

    private ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function showProject($projectId)
    {
        return $this->projectRepository->showProject($projectId);
    }

    public function createProject($teamId,CreateProjectRequest $request)
    {
        return $this->projectRepository->createProject($teamId,$request->validated());
    }

}
