<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'slide id'=>$this->id,
            'image'=>asset('storage/'.$this->image),
            'video'=>asset('storage/'.$this->video)
        ];
    }
}
