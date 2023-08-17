<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Home\SubCategoryResource;

class OneCategoryResource extends JsonResource
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
            'category id'=>$this->id,
            'category name'=>$this->category_name,
            'sub categories'=>SubCategoryResource::collection($this->subCategory)
        ];
    }
}
