<?php

namespace App\Interfaces;

interface TaskRepositoryInterface{

    public function findTask($taskId);

    public function createTask($projectId,array $data);

    public function assignTask($task, array $data);

    public function tasksWithFilter(array $data);

}
