<?php

namespace App\Http\Controllers\Home;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Home\ProviderResource;
use App\Http\Resources\Home\AllProviderResource;

class HomeProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::all();
        $resource = AllProviderResource::collection($providers);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }


    public function show($id)
    {
        $provider = Provider::findorfail($id);
        $resource = ProviderResource::make($provider);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }
}
