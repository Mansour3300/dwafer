<?php

namespace App\Http\Resources\Provider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Home\AllProviderResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Provider\ChildProfileResource;

class ProfileResource extends JsonResource
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
            'bio'=>$this->bio,
            'image'=>asset('storage/'.$this->image),
             ChildProfileResource::collection(
             DB::table('providers')
            ->join('profiles','providers.id','=','profiles.provider_id')
            ->select('providers.*')
            ->get())
        ];
    }
}
