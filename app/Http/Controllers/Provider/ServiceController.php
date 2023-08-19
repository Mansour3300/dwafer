<?php

namespace App\Http\Controllers\Provider;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service = Service::all();
        return response()->json(['success'=>'true','data'=>$service]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::where('provider_id',auth()->guard('developer')->id())->finorfail($id)->get();
        return response()->json(['success'=>'true','data'=>$service]);
    }

    public function acceptService($id){
        $check = Service::findorfail($id);
        if($check->provider_id == auth()->guard('developer')->id()){
           $check->update(['status'=>'accepted']);
           return response()->json(['status'=>'success','message'=>'service accepted']);
        }else{
           return response()->json(['status'=>'failed','message'=>'this request is not avilable']);
        }
    }

    public function refuseService($id){
        $check = Service::findorfail($id);
        if($check->provider_id == auth()->guard('developer')->id()){
           $check->update(['status'=>'refused']);
           return response()->json(['status'=>'success','message'=>'service refused']);
        }else{
           return response()->json(['status'=>'failed','message'=>'this request is not avilable']);
        }
   }

    public function pickService($id){
        $check = Service::findorfail($id);
        if($check->provider_id == null){
           $check->update(['provider_id'=>auth()->guard('developer')->id(),
                           'status'=>'accepted']);
           return response()->json(['status'=>'success','data'=>$check]);
        }else{
           return response()->json(['status'=>'failed','message'=>'this request is not avilable']);
        }
   }
}
