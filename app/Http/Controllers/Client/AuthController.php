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
        $user['otp_code']=rand(0000,9999);
        $user_information = User::create($user);
        $token = auth('api')->attempt([
            'phone'=>$request->phone,
            'country_code'=>$request->country_code,
            'password'=>$request->password
        ]);
        $resource = ClientResource::make($user_information);
        return response()->json(['status'=>'success','data'=>[$resource,'token'=>$token],'message'=>trans('message.auth.you_are_now_registered')]);

}
/*------------------------------------------------------------------------------------------*/
    //this function verify account


    public function verifyAccount(VerifyAccountRequest $request){

        $request->validated();
        $user = User::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone,
                             'country_code'=>$request->country_code])->firstorfail();
        if($user->exists()){
            $user->update(['activation'=>'active','otp_code'=>rand(0000,9999)]);
            $resource = ClientResource::make($user);
            return response()->json(['success'=>'true','data'=>$resource,'message'=>trans('message.auth.your_account_is_now_active')]);
        }else{
            // $user->update(['otp_code'=>rand(0000,9999)]);
            return response()->json(['status'=>'fail','data'=>null,'message'=>trans('message.auth.your_code_is_not_valied')]);
        }
    }

/*----------------------------------------------------------------------------------------*/


public function login(LoginRequest $request){

        $login_data = $request->validated();
        if($token = auth()->guard('api')->attempt($login_data)){
            $user = auth()->guard('api')->user();
            $resource = ClientResource::make($user);
            return response()->json(['status'=>'success','data'=>[$resource,'token'=>$token],'message'=>'']);
        }else{
            return response()->json(['status'=>'fail','data'=>null,'message'=>trans('message.auth.access_denied')]);
            }
}
/*------------------------------------------------------------------------------------------*/

    public function logout()
    {
        auth()->logout();
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.auth.you_are_loged_out')]);
    }
/*------------------------------------------------------------------------------------------*/

    public function forgot(ForgotPassRequest $request){

        $request->validated();
        $user = User::where(['phone'=>$request->phone,
                             'country_code'=>$request->country_code])->firstorfail();
        // $user->notify(new ForgotPassOtpNotification());
        $resource = ClientResource::make($user);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>trans('message.auth.an_otp_number_sent_to_your_phone_number')]);
    }

    /*----------------------------------------------------------------------------------------*/
        //code to reset password

    public function resetcode(ResetCodeRequest $request){

        $request->validated();
        $user = User::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone,
                             'country_code'=>$request->country_code])->firstorfail();
        if($user->exists()){
            $resource = ClientResource::make($user);
            $user->update(['otp_code'=>rand(0000,9999)]);
            return response()->json(['success'=>'true','data'=>$resource,'message'=>trans('message.auth.code_is_valied')]);
        }else{
            return response()->json(['success'=>'fail','data'=>null,'message'=>trans('message.auth.code_is_not_valied')]);
        }
    }
    /*---------------------------------------------------------------------------------------*/
        //to reset password

    public function resetpass(ResetPassRequest $request){

        $request->validated();
        $user = User::where(['phone'=>$request->phone,
                             'country_code'=>$request->country_code])->firstorfail();
        $user->update(['password'=>$request->password]);
        $user->tokens()->delete();
        $resource = ClientResource::make($user);
        return response()->json(['status'=>'success','data'=>$resource,'message'=>trans('message.auth.your_passowrd_is_now_changed_successfully')]);
    }

}


