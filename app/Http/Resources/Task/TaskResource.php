<?php

namespace App\Http\Resources\Task;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'user_name'     => $this->user_name,
            'project_id'    => $this->project_id,
            'project_name'  => $this->project_name,
            'title'         => $this->title,
            'status'        => $this->status,
            'due_date'      => Carbon::parse($this->due_date)->format('Y-m-d H:i:s'),
            'created_at'    => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
