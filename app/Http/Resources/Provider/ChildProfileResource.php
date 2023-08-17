<?php

namespace App\Http\Resources\Provider;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\Home\ProviderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildProfileResource extends JsonResource
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
            'developer id'=>$this->id,
            'developer name'=>$this->full_name,
            'title'=>$this->job_title,
            'city'=>$this->city,
            'project count'=>Project::where('provider_id',auth()->guard('developer')->id())->count(),
            // 'projects'=>Project::where('provider_id',auth()->guard('developer')->id())->get()
        ];
    }
}
