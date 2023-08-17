<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'blog id'=>$this->id,
            'blog name'=>$this->blog_name,
            'blog image'=>asset('storage/'.$this->image),
            'blog discreption'=>$this->blog_discreption,
            'created at'=>date_format($this->created_at,'Y-M-D')
        ];
    }
}
