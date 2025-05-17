<?php

namespace App\Repositories;

use App\Events\TaskAssigned;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface {

    public function findTask($taskId)
    {
        return Task::findOrFail($taskId);
    }

    public function createTask($projectId,$data)
    {
        return Task::create([
            'project_id'    => $projectId,
            'title'         => $data['title'],
            'status'        => empty($data['status']) ? 'todo' : $data['status'],
            'due_date'      => empty($data['due_date']) ? now()->addHours(24) : $data['due_date'],
        ]);

    }

    public function assignTask($task, $data)
    {
        $task->update(['user_id' => $data['member_id']]);

        event(new TaskAssigned($task));

        return $task;
    }

    public function tasksWithFilter($data){

        return Task::query()
            ->when( !empty($data['status']) , fn($q) =>
                $q->where('status', $data['status'])
            )
            ->when( !empty($data['due_date']) , fn($q) =>
                $q->whereDate('due_date', $data['due_date'])
            )
            ->when( !empty($data['member_id']) , fn($q) =>
                $q->where('user_id', $data['member_id'])
            )
            ->orderBy('created_at', 'desc')
            ->get();

    }
}
