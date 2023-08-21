<?php

namespace App\Http\Controllers\Home;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Home\ProviderResource;

class HomeSearchController extends Controller
{
    public function search($term){
        $search = Provider::where('full_name', 'like','%'.$term. '%')->get();
        if(count($search)){
            $resource = ProviderResource::collection($search);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
        }
        return response()->json(['status'=>'fail','data'=>null,'message'=>trans('message.search.no_such_result_found')]);
        }
}
