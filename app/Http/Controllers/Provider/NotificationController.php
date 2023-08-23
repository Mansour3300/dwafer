<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\NotificationResource;

class NotificationController extends Controller
{
    public function notification(){
        $provider = auth()->guard('developer')->user();
        // dd($provider);
        $not = $provider->notifications;
        $noty = NotificationResource::collection($not);
        return response()->json(['status'=>'success','data'=>$noty,'message'=>'']);
    }
}
