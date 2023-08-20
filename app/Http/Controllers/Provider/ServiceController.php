<?php

namespace App\Http\Controllers\Provider;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ServiceResource;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service = Service::all();
        $resource = ServiceResource::collection($service);
        return response()->json(['status'=>'success','data'=>$resource]);
    }


    public function myWork()
    {
        $service = Service::where('provider_id',auth()->guard('developer')->id())->get();
        $resource = ServiceResource::collection($service);
        return response()->json(['status'=>'success','data'=>null,'data'=>$resource]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::where('provider_id',auth()->guard('developer')->id())->findorfail($id)->get();
        $resource = ServiceResource::make($service);
        return response()->json(['status'=>'success','data'=>null,'data'=>$resource]);
    }

    public function acceptService($id){
        $check = Service::findorfail($id);
        if($check->provider_id == auth()->guard('developer')->id()){
           $check->update(['status_of_request'=>'accepted']);
           return response()->json(['status'=>'success','data'=>null,'message'=>'service accepted']);
        }else{
           return response()->json(['status'=>'failed','data'=>null,'message'=>'this request is not avilable']);
        }
    }

    public function refuseService($id){
        $check = Service::findorfail($id);
        if($check->provider_id == auth()->guard('developer')->id()){
           $check->update(['status_of_request'=>'refused']);
           return response()->json(['status'=>'success','data'=>null,'message'=>'service refused']);
        }else{
           return response()->json(['status'=>'failed','data'=>null,'message'=>'this request is not avilable']);
        }
   }

    public function pickService($id){
        $check = Service::findorfail($id);
        if($check->provider_id == null){
           $check->update(['provider_id'=>auth()->guard('developer')->id(),
                           'status_of_request'=>'accepted']);
           return response()->json(['status'=>'success','data'=>$check]);
        }else{
           return response()->json(['status'=>'failed','data'=>null,'message'=>'this request is not avilable']);
        }
   }
}
