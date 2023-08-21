<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Client\LoginRequest;
use App\Http\Requests\Client\ResetCodeRequest;
use App\Http\Requests\Client\ResetPassRequest;
use App\Http\Requests\Client\ForgotPassRequest;
use App\Http\Requests\Client\RegisterationRequest;
use App\Http\Requests\Client\VerifyAccountRequest;

class AuthController extends Controller
{
    public function register(RegisterationRequest $request){

        $newuser= $request->validated();
        $newuser['otp_code']=rand(0000,9999);
        User::create($newuser);
            return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.auth.you_are_now_registered')]);

}
/*------------------------------------------------------------------------------------------*/
    //this function verify account


    public function verifyAccount(VerifyAccountRequest $request){

        $otp = $request->validated();
        $user = User::where('otp_code',$otp);
        if($user->exists()){
            $user->update(['activation'=>'active']);
            return response()->json(['success'=>'true','data'=>null,'message'=>trans('message.auth.your_account_is_now_active')]);
        }else{
            return response()->json(['success'=>'false','data'=>null,'message'=>trans('message.auth.your_code_is_not_valied')]);
        }
    }

/*----------------------------------------------------------------------------------------*/


public function login(LoginRequest $request){

        $login_data = $request->validated();
        if($token = auth()->guard('api')->attempt($login_data)){
            return response()->json(['status'=>'success','token'=>$token]);
        }else{
            return response()->json(['status'=>'failed','data'=>null,'message'=>trans('message.auth.access_denied')]);
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

        $phone = $request->validated();
        $user = User::where('phone',$phone)->first();
        // $user->notify(new ForgotPassOtpNotification());
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.auth.an_otp_number_sent_to_your_phone_number')]);
    }

    /*----------------------------------------------------------------------------------------*/
        //code to reset password

    public function resetcode(ResetCodeRequest $request){

        $request->validated();
        $user = User::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone])->first();
        if($user->exists()){
            return response()->json(['success'=>'true','data'=>null,'message'=>trans('message.auth.code_is_valied')]);
        }else{
            return response()->json(['success'=>'true','data'=>null,'message'=>trans('message.auth.code_is_not_valied')]);
        }
    }
    /*---------------------------------------------------------------------------------------*/
        //to reset password

    public function resetpass(ResetPassRequest $request){

        $request->validated();
        $user = User::where('phone',$request->phone)->first();
        $user->update([$request->password]);
        $user->tokens()->delete();

        return response()->json(['success'=>'true','data'=>null,'message'=>trans('message.auth.your_passowrd_is_now_changed_successfully')]);
    }

}


