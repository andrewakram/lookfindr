<?php

namespace App\Interfaces;

interface ProjectRepositoryInterface{

    public function showProject($projectId);

    public function createProject($teamId,array $data);

}
