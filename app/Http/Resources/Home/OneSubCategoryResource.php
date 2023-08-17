<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use App\Http\Resources\Home\ProviderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OneSubCategoryResource extends JsonResource
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
            'sub category id'=>$this->id,
            'sub category name'=>$this->sub_category_name,
            'providers'=>ProviderResource::collection($this->developer)
        ];
    }
}
