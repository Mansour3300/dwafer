<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Home\ProjectResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
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
            // 'image'=>asset('storage/'.$this->image),
            // 'rate'=>$this->rate,
            'provider'=>ProjectResource::collection(
                DB::table('providers')
                        ->join('projects','providers.id','=','projects.provider_id')
                        ->select('projects.*')
                        ->get()
        )];
    }
}
