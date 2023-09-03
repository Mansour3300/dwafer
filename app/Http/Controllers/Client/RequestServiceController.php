<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Service;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ServiceNotification;
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
        return response()->json(['status'=>'success','data'=>$resource,'message'=>''],200);
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
        if($request->provider_id != null){
            $user = User::where('id',auth()->id())->first();
                $provider = Provider::where('id',$request->provider_id)->firstorfail();
                $provider->notify(new ServiceNotification($user));
        }
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.service.new_service_request_added')],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service_request = Service::where('user_id',auth('api')->id())->findorfail($id);
        $resource = ServiceResource::make($service_request);
        return response()->json(['status'=>'success','data'=>null,'data'=>$resource,'message'=>''],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, string $id)
    {
        $request->validated();
        $service = Service::where('user_id',auth('api')->id())->findorfail($id);
        if($service->status == 'refused'){
            return response()->json(['status'=>'fail','data'=>null,'message'=>trans('message.service.sorry_your_service_has_been_refused')],200);
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
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.service.service_updated')],200);
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
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.service.service_just_deleted')],200);
    }
}
