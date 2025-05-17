<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\AssignTaskRequest;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\TasksWithFilterRequest;
use App\Http\Resources\Task\TaskResource;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Task;
use App\Services\TaskService;
use App\Services\ProjectService;
use App\Traits\ApiResponserTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use ApiResponserTrait,AuthorizesRequests;

    private TaskService $taskService;
    private ProjectService $projectService;
    private TaskRepositoryInterface $taskRepository;
    private ProjectRepositoryInterface $projectRepository;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        ProjectRepositoryInterface $projectRepository
    ){
        $this->taskRepository       = $taskRepository;
        $this->projectRepository    = $projectRepository;
        $this->taskService          = new TaskService($this->taskRepository);
        $this->projectService       = new ProjectService($this->projectRepository);
    }

    public function addTask($projectId,CreateTaskRequest $request)
    {
        $project = $this->projectService->showProject($projectId);

        $this->authorize('create', [Task::class, $project]);

        return $this->successResponse(new TaskResource($this->taskService->createTask($projectId,$request)));
    }

    public function assignTask($taskId,AssignTaskRequest $request)
    {
        $request = $request->validated();

        $task = $this->taskService->findTask($taskId);

        $this->authorize('assign', $task);

        $this->taskService->assignTask($task,$request);

        return $this->successResponse();
    }

    public function tasksWithFilter(TasksWithFilterRequest $request)
    {
        return $this->successResponse(TaskResource::collection($this->taskService->tasksWithFilter($request)));
    }
}
