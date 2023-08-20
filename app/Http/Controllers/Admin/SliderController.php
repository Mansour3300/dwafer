<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Http\Resources\Home\SliderResource;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Slider = Slider::paginate(5);
        $resource = SliderResource::collection($Slider);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        $new_slide = $request->validated();
        $new_slide['image']=$request->file('image')->store('image','public');
        $new_slide['video']=$request->file('video')->store('video','public');
        Slider::create($new_slide);
        return response()->json(['status'=>'success','data'=>null,'message'=>'you added new slide successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Slider = Slider::findorfail($id);
        $resource = SliderResource::make($Slider);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, string $id)
    {
        $update_slide = $request->validated();
        $Slider = Slider::findorfail($id);
        $Slider->update([
            $update_slide['image']=$request->file('image')->store('image','public'),
            $update_slide['video']=$request->file('video')->store('video','public')
        ]);
        return response()->json(['status'=>'success','data'=>null,'message'=>'you updated slide successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slide_image = Slider::findorfail($id)->image;
        $slide_video = Slider::findorfail($id)->video;
        $slide = Slider::findorfail($id);
        unlink(storage_path('app/public/'.$slide_image));
        unlink(storage_path('app/public/'.$slide_video));
        $slide->delete();
        return response()->json(['status'=>'success','data'=>null,'message'=>'slide just deleted']);
    }
}
