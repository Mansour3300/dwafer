<?php

namespace App\Http\Controllers\Client;

use App\Models\Chat;
use App\Models\User;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ChatRequest;
use App\Http\Resources\Client\ChatResource;
use App\Notifications\ClientChatNotification;
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
                        ->distinct('provider_id')//لعدم تكرار المستخدمين
                        ->get();
                        $resource = AllChatResource::collection($chat);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>''],200);
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
                ///////////////////////
                $user = User::where('id',auth()->id())->first();
                $provider = Provider::where('id',$new_message['provider_id'])->first();
                $provider->notify(new ClientChatNotification($user));
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.chat.you_sent_a_new_message')],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chat = Chat::where('user_id',auth('api')->id())
                      ->where('provider_id',$id)->get();
                      $resource = ChatResource::collection($chat);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>''],200);
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
        ->findorfail($id)->delete();//لو همسح الشات من طرف واحد هعمل عمود delete id واتحقق منه الللى يحذف يضاف اى دى بتاع فى العمود وعند العرض لو الاى دى موجود بعرض فارغ
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.chat.you_deleted_this_message'),200]);
    }
}
