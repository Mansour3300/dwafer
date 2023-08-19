<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ServiceRequest;
use App\Models\Service;

class RequestServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service = Service::where('user_id',auth('api')->id())->get();
        return response()->json(['success'=>'true','data'=>$service]);
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
        return response()->json(['success'=>'true','message'=>'new service request added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service_request = Service::where('user_id',auth('api')->id())->finorfail($id)->get();
        return response()->json(['success'=>'true','data'=>$service_request]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, string $id)
    {
        $request->validated();
        $service = Service::findorfail($id);
        if($service->status == 'refused'){
            return response()->json(['success'=>'fail','message'=>'sorry your service has been refused']);
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
        return response()->json(['status'=>'success','message'=>'service just deleted']);
    }
}
