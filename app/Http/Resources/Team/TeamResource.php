<?php

namespace App\Http\Resources\Team;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Routing\Loader\Configurator\collection;

class TeamResource extends JsonResource
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
            'name'          => $this->name,
            'created_at'    => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'members'       => !empty($this->members) ? TeamMemberResource::collection($this->members) : [],
        ];
    }
}
