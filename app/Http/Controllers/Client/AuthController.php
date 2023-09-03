<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Client\LoginRequest;
use App\Http\Resources\Client\ClientResource;
use App\Http\Requests\Client\ResetCodeRequest;
use App\Http\Requests\Client\ResetPassRequest;
use App\Http\Requests\Client\ForgotPassRequest;
use App\Http\Requests\Client\RegisterationRequest;
use App\Http\Requests\Client\VerifyAccountRequest;

class AuthController extends Controller
{
    public function register(RegisterationRequest $request){

        $user= $request->validated();
        $user['otp_code']=rand(1111,9999);
        $user_information = User::create($user);
        $token = auth('api')->attempt([
            'phone'=>$request->phone,
            'country_code'=>$request->country_code,
            'password'=>$request->password
        ]);
        data_set($user_information, 'token', $token);//بضيف للمتغير بتاعى كى وفاليو زياده على اللى فيه
        $resource = ClientResource::make($user_information);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>trans('message.auth.you_are_now_registered')],200);

}
/*------------------------------------------------------------------------------------------*/
    //this function verify account


    public function verifyAccount(VerifyAccountRequest $request){

        $request->validated();
        $user = User::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone,
                             'country_code'=>$request->country_code])->firstorfail();
        if($user){
            $user->update(['activation'=>'active','otp_code'=>rand(1111,9999)]);//for status we use bool column
            $resource = ClientResource::make($user);
            return response()->json(['success'=>'true','data'=>$resource,'message'=>trans('message.auth.your_account_is_now_active')],200);
        }else{
            // $user->update(['otp_code'=>rand(0000,9999)]);
            return response()->json(['status'=>'fail','data'=>null,'message'=>trans('message.auth.your_code_is_not_valied')],422);
        }
    }

/*----------------------------------------------------------------------------------------*/


public function login(LoginRequest $request){

        $login_data = $request->validated();
        if($token = auth()->guard('api')->attempt($login_data)){
            $user = auth()->guard('api')->user();
            data_set($user, 'token', $token);
            $resource = ClientResource::make($user);
            return response()->json(['status'=>'success','data'=>$resource,'message'=>'']);
        }else{
            return response()->json(['status'=>'fail','data'=>null,'message'=>trans('message.auth.access_denied')],403);
            }
}
/*------------------------------------------------------------------------------------------*/

    public function logout()
    {
        auth('api')->logout();  //will be logedout with device token that stored in database
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.auth.you_are_loged_out'),200]);
    }
/*------------------------------------------------------------------------------------------*/

    public function forgot(ForgotPassRequest $request){

        $request->validated();
        $user = User::where(['phone'=>$request->phone,
                             'country_code'=>$request->country_code])->firstorfail();
        // $user->notify(new ForgotPassOtpNotification());
        //here we will generate new otp_code
        //$user->update(['otp_code'=>mt.rand(1111,9999)]);
        $resource = ClientResource::make($user);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>trans('message.auth.an_otp_number_sent_to_your_phone_number'),200]);
    }

    /*----------------------------------------------------------------------------------------*/
        //code to reset password

    public function resetcode(ResetCodeRequest $request){

        $request->validated();
        $user = User::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone,
                             'country_code'=>$request->country_code])->firstorfail();
        if($user){
            $resource = ClientResource::make($user);
            $user->update(['otp_code'=>rand(1111,9999)]);
            return response()->json(['success'=>'true','data'=>$resource,'message'=>trans('message.auth.code_is_valied')],200);
        }else{
            return response()->json(['success'=>'fail','data'=>null,'message'=>trans('message.auth.code_is_not_valied')],422);
        }
    }
    /*---------------------------------------------------------------------------------------*/
        //to reset password

    public function resetpass(ResetPassRequest $request){

        $request->validated();
        $user = User::where(['phone'=>$request->phone,
                             'country_code'=>$request->country_code])->firstorfail();
        $user->update(['password'=>$request->password]);
        // $user->tokens()->delete();
        $resource = ClientResource::make($user);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>trans('message.auth.your_passowrd_is_now_changed_successfully')],200);
    }

}


