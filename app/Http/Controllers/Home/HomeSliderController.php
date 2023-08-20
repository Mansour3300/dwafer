<?php

namespace App\Http\Controllers\Home;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Home\SliderResource;

class HomeSliderController extends Controller
{
    public function index()
    {
        $slider = Slider::paginate(5);
        $resource = SliderResource::collection($slider);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }
}
