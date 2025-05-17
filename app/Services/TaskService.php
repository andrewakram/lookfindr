<?php

namespace App\Services;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\TasksWithFilterRequest;
use App\Interfaces\TaskRepositoryInterface;

class TaskService{

    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function findTask($taskId){
        return $this->taskRepository->findTask($taskId);
    }

    public function createTask($projectId,CreateTaskRequest $request)
    {
        return $this->taskRepository->createTask($projectId,$request->validated());
    }

    public function assignTask($task, $request)
    {
        return $this->taskRepository->assignTask($task,$request);
    }

    public function tasksWithFilter(TasksWithFilterRequest $request)
    {
        return $this->taskRepository->tasksWithFilter($request->validated());
    }

}
