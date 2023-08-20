<?php

namespace App\Http\Controllers\Client;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ServiceRequest;
use App\Http\Resources\Client\ServiceResource;

class RequestServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service = Service::where('user_id',auth('api')->id())->get();
        $resource = ServiceResource::collection($service);
        return response()->json(['status'=>'success','data'=>$resource]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        $service = $request->validated();
        $service['attachment']=$request->file('attachment')->store('file','public');
        $service['user_id']=auth('api')->id();
        Service::create($service);
        return response()->json(['status'=>'success','data'=>null,'message'=>'new service request added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service_request = Service::where('user_id',auth('api')->id())->findorfail($id);
        $resource = ServiceResource::make($service_request);
        return response()->json(['status'=>'success','data'=>null,'data'=>$resource]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, string $id)
    {
        $request->validated();
        $service = Service::where('user_id',auth('api')->id())->findorfail($id);
        if($service->status == 'refused'){
            return response()->json(['status'=>'fail','data'=>null,'message'=>'sorry your service has been refused']);
        }else{
        $service->update([
            'attachment'=>$request->file('attachment')->store('file','public'),
            'title'=>$request->title,
            'due_date'=>$request->due_date,
            'description'=>$request->description,
            'service_type'=>$request->service_type,
            'budget'=>$request->budget,
            'provider_id'=>$request->provider_id
        ]);
        return response()->json(['status'=>'success','data'=>null,'message'=>'service updated']);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service_attachment = Service::findorfail($id)->attachment;
        $service = Service::findorfail($id);
        unlink(storage_path('app/public/'.$service_attachment));
        $service->delete();
        return response()->json(['status'=>'success','data'=>null,'message'=>'service just deleted']);
    }
}
