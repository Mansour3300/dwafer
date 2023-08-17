<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\ResetCodeRequest;
use App\Http\Requests\Admin\ResetPassRequest;
use App\Http\Requests\Admin\ForgotPassRequest;
use App\Http\Requests\Admin\RegisterationRequest;
use App\Http\Requests\Admin\VerifyAccountRequest;

class AdminAuthController extends Controller
{
    public function adminRegister(RegisterationRequest $request){

        $new_admin= $request->validated();
        $new_admin['password']=Hash::make($new_admin['password']);
        $new_admin['otp_code']=rand(0000,9999);
        $new_admin['type']='admin';
        User::create($new_admin);
            return response()->json(['status'=>'success','message'=>'yor are now registered']);

}
/*------------------------------------------------------------------------------------------*/
    //this function verify account


    public function verifyAccount(VerifyAccountRequest $request){

        $otp = $request->validated();
        $user = User::where('otp_code',$otp);
        if($user->exists()){
            $user->update(['activation'=>'active']);
            return response()->json(['success'=>'true','message'=>'your account is now active']);
        }else{
            return response()->json(['success'=>'false','message'=>'your code is not valied']);
        }
    }

/*----------------------------------------------------------------------------------------*/


public function login(LoginRequest $request){

        $login_data = $request->validated();
        if($token = auth('api')->attempt($login_data)){
            return response()->json(['status'=>'success','token'=>$token]);
        }else{
            return response()->json(['status'=>'failed','message'=>'access denied']);
            }
}
/*------------------------------------------------------------------------------------------*/

    public function logout()
    {
        auth()->logout();
        return response()->json(['status'=>'success','message'=>'you are loged out']);
    }
/*------------------------------------------------------------------------------------------*/

    public function forgot(ForgotPassRequest $request){

        $phone = $request->validated();
        $user = User::where('phone',$phone)->first();
        // $user->notify(new ForgotPassOtpNotification());
        return response()->json(['status'=>'success','message'=>'an otp number sent to your phone number']);
    }

    /*----------------------------------------------------------------------------------------*/
        //code to reset password

    public function resetcode(ResetCodeRequest $request){

        $request->validated();
        $user = User::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone])->first();
        if($user->exists()){
            return response()->json(['success'=>'true','message'=>'code is valied']);
        }else{
            return response()->json(['success'=>'true','message'=>'code is not valied']);
        }
    }
    /*---------------------------------------------------------------------------------------*/
        //to reset password

    public function resetpass(ResetPassRequest $request){

        $request->validated();
        $user = User::where('phone',$request->phone)->first();
        $user->update(['password'=>Hash::make($request->password)]);
        $user->tokens()->delete();
        return response()->json(['success'=>'true','message'=>'your passowrd is now changed successfully']);
    }

    /*-------------------------------------------------------------------------------------*/
        //to delete account

    public function destroy($id){
        User::findorfail($id)->delete();
        return response()->json(['success'=>'true','message'=>'account deleted successfully']);
    }
}
