<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'project id'=>$this->id,
            'project name'=>$this->project_name,
            'project image'=>asset('storage/'.$this->project_image),
            'likes'=>$this->likes
        ];
    }
}
