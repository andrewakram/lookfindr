<?php

namespace App\Repositories;

use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface {

    public function showProject($projectId){
        return Project::whereId($projectId)
            ->with(['team'=>function($q){
                $q->with('members');
            }])
            ->first();
    }

    public function createProject($teamId,$data)
    {
        return Project::create([
            'team_id'       => $teamId,
            'name'          => $data['name'],
            'description'   => $data['description'],
            'status'        => $data['status'],
        ]);

    }
}
