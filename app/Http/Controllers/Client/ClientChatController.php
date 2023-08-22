<?php

namespace App\Http\Controllers\Client;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ChatRequest;
use App\Http\Resources\Client\ChatResource;
use App\Http\Resources\Client\AllChatResource;

class ClientChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
                        $chat = DB::table('chats')
                        ->where('user_id',auth('api')->id())
                        ->join('providers','providers.id','chats.provider_id')
                        ->select('full_name','providers.id')
                        ->distinct('provider_id')
                        ->get();
                        $resource = AllChatResource::collection($chat);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChatRequest $request)
    {
        $new_message = $request->validated();
        $new_message['user_id']=auth('api')->id();
        $new_message['sender']='user';
        Chat::create($new_message);
        return response()->json(['status'=>'success','data'=>null,'message'=>'you sent a new message']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chat = Chat::where('user_id',auth('api')->id())
                      ->where('provider_id',$id)->get();
                      $resource = ChatResource::collection($chat);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Chat::where('user_id',auth('api')->id())
        ->where('sender','user')
        ->findorfail($id)->delete();
        return response()->json(['status'=>'success','data'=>null,'message'=>'you deleted this message']);
    }
}
