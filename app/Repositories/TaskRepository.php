<?php

namespace App\Repositories;

use App\Events\TaskAssigned;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use App\Models\TaskLog;

class TaskRepository implements TaskRepositoryInterface {

    public function findTask($taskId)
    {
        return Task::findOrFail($taskId);
    }

    public function createTask($projectId,$data)
    {
        \DB::beginTransaction();

        $task = Task::create([
            'project_id'    => $projectId,
            'title'         => $data['title'],
            'status'        => empty($data['status']) ? 'todo' : $data['status'],
            'due_date'      => empty($data['due_date']) ? now()->addHours(24) : $data['due_date'],
        ]);

        TaskLog::create([
            'user_id'   => auth()->user()->id,
            'task_id'   => $task->id,
            'old_value' => null,
            'new_value' => json_encode($task),
        ]);

        \DB::commit();

        return $task;

    }

    public function assignTask($task, $data)
    {
        \DB::beginTransaction();

        $task->update(['user_id' => $data['member_id']]);

        TaskLog::create([
            'user_id'   => auth()->user()->id,
            'task_id'   => $task->id,
            'old_value' => json_encode($task),
            'new_value' => json_encode($this->findTask($task->id)),
        ]);
        event(new TaskAssigned($task));

        \DB::commit();

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
