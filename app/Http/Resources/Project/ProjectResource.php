<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\Module\ModuleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'type' => Str::singular($this->getTable()),
            'name' => $this->name,
            'status' => $this->model,
            'parent_id' => $this->parent_id,
            'description' => $this->description,
            'owner' => $this->whenLoaded('user'),
            'modules_count' => $this->modules_count,
            'project_status_id' => $this->project_status_id,
            'modules' => ModuleResource::collection($this->whenLoaded('modules')),
            'meta' => [
                'permissions' => [
//                    'edit' => $this->user_id === auth()->user()->id,
//                    'delete' => $this->user_id === auth()->user()->id,
                ]
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
