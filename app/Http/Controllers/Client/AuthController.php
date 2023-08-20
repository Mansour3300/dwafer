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
        $newuser['password']=Hash::make($newuser['password']); //ned set attarbute in model
        $newuser['otp_code']=rand(0000,9999);
        User::create($newuser);
            return response()->json(['status'=>'success','data'=>null,'message'=>trans('auth.auth.your_are_now_registered')]);

}
/*------------------------------------------------------------------------------------------*/
    //this function verify account


    public function verifyAccount(VerifyAccountRequest $request){

        $otp = $request->validated();
        $user = User::where('otp_code',$otp);
        if($user->exists()){
            $user->update(['activation'=>'active']);
            return response()->json(['success'=>'true','data'=>null,'message'=>'your account is now active']);
        }else{
            return response()->json(['success'=>'false','data'=>null,'message'=>'your code is not valied']);
        }
    }

/*----------------------------------------------------------------------------------------*/


public function login(LoginRequest $request){

        $login_data = $request->validated();
        if($token = auth()->guard('api')->attempt($login_data)){
            return response()->json(['status'=>'success','token'=>$token]);
        }else{
            return response()->json(['status'=>'failed','data'=>null,'message'=>'access denied']);
            }
}
/*------------------------------------------------------------------------------------------*/

    public function logout()
    {
        auth()->logout();
        return response()->json(['status'=>'success','data'=>null,'message'=>'you are loged out']);
    }
/*------------------------------------------------------------------------------------------*/

    public function forgot(ForgotPassRequest $request){

        $phone = $request->validated();
        $user = User::where('phone',$phone)->first();
        // $user->notify(new ForgotPassOtpNotification());
        return response()->json(['status'=>'success','data'=>null,'message'=>'an otp number sent to your phone number']);
    }

    /*----------------------------------------------------------------------------------------*/
        //code to reset password

    public function resetcode(ResetCodeRequest $request){

        $request->validated();
        $user = User::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone])->first();
        if($user->exists()){
            return response()->json(['success'=>'true','data'=>null,'message'=>'code is valied']);
        }else{
            return response()->json(['success'=>'true','data'=>null,'message'=>'code is not valied']);
        }
    }
    /*---------------------------------------------------------------------------------------*/
        //to reset password

    public function resetpass(ResetPassRequest $request){

        $request->validated();
        $user = User::where('phone',$request->phone)->first();
        $user->update(['password'=>Hash::make($request->password)]);
        $user->tokens()->delete();

        return response()->json(['success'=>'true','data'=>null,'message'=>'your passowrd is now changed successfully']);
    }

}


