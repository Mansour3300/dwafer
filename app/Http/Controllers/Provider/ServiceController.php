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
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }


    public function myWork()
    {
        $service = Service::where('provider_id',auth()->guard('developer')->id())->get();
        $resource = ServiceResource::collection($service);
        return response()->json(['status'=>'success','message'=>'','data'=>$resource]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::where('provider_id',auth()->guard('developer')->id())->findorfail($id)->get();
        $resource = ServiceResource::make($service);
        return response()->json(['status'=>'success','message'=>'','data'=>$resource]);
    }

    public function acceptService($id){
        $check = Service::findorfail($id);
        if($check->provider_id == auth()->guard('developer')->id()){
           $check->update(['status_of_request'=>'accepted']);
           return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.service.service_accepted')]);
        }else{
           return response()->json(['status'=>'failed','data'=>null,'message'=>trans('message.service.this_request_is_not_avilable')]);
        }
    }

    public function refuseService($id){
        $check = Service::findorfail($id);
        if($check->provider_id == auth()->guard('developer')->id()){
           $check->update(['status_of_request'=>'refused']);
           return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.service.service_refused')]);
        }else{
           return response()->json(['status'=>'failed','data'=>null,'message'=>trans('message.service.this_request_is_not_avilable')]);
        }
   }

    public function pickService($id){
        $check = Service::findorfail($id);
        if($check->provider_id == null){
           $check->update(['provider_id'=>auth()->guard('developer')->id(),
                           'status_of_request'=>'accepted']);
           return response()->json(['status'=>'success','data'=>$check,'message'=>'']);
        }else{
           return response()->json(['status'=>'failed','data'=>null,'message'=>trans('message.service.this_request_is_not_avilable')]);
        }
   }
}
