<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
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
            'sub category'=>$this->sub_category_name,
            'sub category image'=>asset('storage/'.$this->sub_category_image)
        ];
    }
}
