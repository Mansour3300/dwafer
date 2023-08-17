<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Home\ProviderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OneProjectResource extends JsonResource
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
            'project id'=>$this->id,
            'project image'=>asset('storage/'.$this->project_image),
            'project discreption'=>$this->project_discreption,
            'created at'=>date_format($this->created_at,'Y-M-D'),
            'provider'=>AllProviderResource::collection(
                DB::table('providers')
                        ->Join('projects','providers.id','=','projects.provider_id')
                        ->select('providers.*')
                        ->get()
            )
        ];
    }
}
