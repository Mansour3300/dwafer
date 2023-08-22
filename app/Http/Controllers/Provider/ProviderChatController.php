<?php

namespace App\Http\Controllers\Provider;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\ChatRequest;
use App\Http\Resources\Client\ChatResource;
use App\Http\Resources\Client\AllChatResource;

class ProviderChatController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chat = DB::table('chats')
                        ->where('provider_id',auth()->guard('developer')->id())
                        ->join('users','users.id','chats.user_id')
                        ->select('full_name','users.id')
                        ->distinct('user_id')
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
        $new_message['provider_id']=auth()->guard('developer')->id();
        $new_message['sender']='provider';
        Chat::create($new_message);
        return response()->json(['status'=>'success','data'=>null,'message'=>'you sent a new message']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chat = Chat::where('provider_id',auth()->guard('developer')->id())
                      ->where('user_id',$id)->get();
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
        Chat::where('provider_id',auth()->guard('developer')->id())
            ->where('sender','provider')
            ->findorfail($id)->delete();
        return response()->json(['status'=>'success','data'=>null,'message'=>'you deleted this message']);
    }
}
