<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'service id'=>$this->id,
            'provider id'=>$this->provider_id,
            'service type'=>$this->service_type,
            'due date'=>$this->due_date,
            'description'=>$this->description,
            'attachment'=>asset('storage/'.$this->attachment),
            'budget'=>$this->budget,
            'title'=>$this->title,
            'status_of_request'=>$this->status_of_request,
            'request date'=>date_format($this->created_at,'Y-m-d')
        ];
    }
}
