<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\NotificationResource;

class ClientNotificationController extends Controller
{
    public function notification(){
        $user = auth()->user();
        $not = $user->notifications;
        $noty = NotificationResource::collection($not);
        return response()->json(['status'=>'success','data'=>$noty,'message'=>''],200);
    }
}
