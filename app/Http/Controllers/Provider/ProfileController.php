<?php

namespace App\Http\Controllers\Provider;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\ProfileRequest;
use App\Http\Resources\Provider\ProfileResource;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = Profile::where('provider_id',auth()->guard('developer')->id())
                      ->firstorfail();
        $resource = ProfileResource::make($profile);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileRequest $request)
    {
        $profile = $request->validated();
        $profile['image']=$request->file('image')->store('image','public');
        $profile['provider_id']=auth()->guard('developer')->id();
        Profile::create($profile);
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.profile.you_made_your_profile')]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = Profile::where('id',$id)
                            ->firstorfail();
        $resource = ProfileResource::make($profile);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, string $id)
    {
        $request->validated();
        $profile = Profile::where('provider_id',auth()->guard('developer')->id())->firstorfail();
        $profile->update([
            'image'=>$request->file('image')->store('image','public'),
            'bio'=>$request->bio
        ]);
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.profile.you_updated_your_profile')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profile_image = Profile::findorfail($id)->image;
        $profile = Profile::findorfail($id);
        unlink(storage_path('app/public/'.$profile_image));
        $profile->delete();
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.profile.profile_just_deleted')]);
    }
}
