<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'name'=>$this->full_name,
            'phone'=>$this->phone,
            'country code'=>$this->country_code,
            'id'=>$this->id,
            'status'=>$this->status
        ];
    }
}
