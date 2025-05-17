<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\Team\TeamResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'team_id'       => $this->team_id,
            'name'          => $this->name,
            'description'   => $this->description,
            'created_at'    => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'team'          => new TeamResource($this->team),
        ];
    }
}
