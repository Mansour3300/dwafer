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
        $new_admin['otp_code']=rand(0000,9999);
        $new_admin['type']='admin';
        User::create($new_admin);
            return response()->json(['status'=>'success','data'=>null,'message'=>trans('auth.auth.you_are_now_registered')]);

}
/*------------------------------------------------------------------------------------------*/
    //this function verify account


    public function verifyAccount(VerifyAccountRequest $request){

        $otp = $request->validated();
        $user = User::where('otp_code',$otp);
        if($user->exists()){
            $user->update(['activation'=>'active']);
            return response()->json(['success'=>'true','data'=>null,'message'=>trans('auth.auth.your_account_is_now_active')]);
        }else{
            return response()->json(['success'=>'false','data'=>null,'message'=>trans('auth.auth.your_code_is_not_valied')]);
        }
    }

/*----------------------------------------------------------------------------------------*/


public function login(LoginRequest $request){

        $login_data = $request->validated();
        if($token = auth('api')->attempt($login_data)){
            return response()->json(['status'=>'success','token'=>$token]);
        }else{
            return response()->json(['status'=>'failed','data'=>null,'message'=>trans('auth.auth.access_denied')]);
            }
}
/*------------------------------------------------------------------------------------------*/

    public function logout()
    {
        auth()->logout();
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('auth.auth.you_are_loged_out')]);
    }
/*------------------------------------------------------------------------------------------*/

    public function forgot(ForgotPassRequest $request){

        $phone = $request->validated();
        $user = User::where('phone',$phone)->first();
        // $user->notify(new ForgotPassOtpNotification());
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('auth.auth.an_otp_number_sent_to_your_phone_number')]);
    }

    /*----------------------------------------------------------------------------------------*/
        //code to reset password

    public function resetcode(ResetCodeRequest $request){

        $request->validated();
        $user = User::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone])->first();
        if($user->exists()){
            return response()->json(['success'=>'true','data'=>null,'message'=>trans('auth.auth.code_is_valied')]);
        }else{
            return response()->json(['success'=>'true','data'=>null,'message'=>trans('auth.auth.code_is_not_valied')]);
        }
    }
    /*---------------------------------------------------------------------------------------*/
        //to reset password

    public function resetpass(ResetPassRequest $request){

        $request->validated();
        $user = User::where('phone',$request->phone)->first();
        $user->update([$request->password]);
        $user->tokens()->delete();
        return response()->json(['success'=>'true','data'=>null,'message'=>trans('auth.auth.your_passowrd_is_now_changed_successfully')]);
    }

    /*-------------------------------------------------------------------------------------*/
        //to delete account

    public function destroy($id){
        User::findorfail($id)->delete();
        return response()->json(['success'=>'true','data'=>null,'message'=>trans('auth.auth.account_deleted_successfully')]);
    }
}
