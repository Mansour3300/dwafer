<?php

namespace App\Http\Controllers\Provider;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Provider\LoginRequest;
use App\Http\Requests\Provider\ResetCodeRequest;
use App\Http\Requests\Provider\ResetPassRequest;
use App\Http\Requests\Provider\ForgotPassRequest;
use App\Http\Requests\Provider\RegisterationRequest;
use App\Http\Requests\Provider\VerifyAccountRequest;



class ProviderAuthController extends Controller
{
    public function register(RegisterationRequest $request){

        $newuser= $request->validated();
        if($newuser['provider_type']=='company'){
            if($request->company_registeration_image==null){
                return response()->json(['status'=>'fail','message'=>'company registeration image can not be empty']);

            }elseif($request->company_registeration_image!=null){
                $newuser['company_registeration_image']= $request->file('company_registeration_image')->store('image','public');
                $newuser['password']=Hash::make($newuser['password']);
                $newuser['otp_code']=rand(0000,9999);
                Provider::create($newuser);
                foreach($request->sub_category_ids as $sub_category_id){
                    $provider = Provider::where('phone',$request->phone)->first();
                    $provider->developerSub()->attach($sub_category_id);
                }
                return response()->json(['status'=>'success','message'=>'your are now registered as a company']);
            }
        }elseif($newuser['provider_type']=='free_lancer'){
                $newuser['password']=Hash::make($newuser['password']);
                $newuser['otp_code']=rand(0000,9999);
                Provider::create($newuser);
                foreach($request->sub_category_ids as $sub_category_id){
                    $provider = Provider::where('phone',$request->phone)->first();
                    $provider->developerSub()->attach($sub_category_id);
                }
                return response()->json(['status'=>'success','message'=>'your are now registered as a freelancer']);
        }

}
/*------------------------------------------------------------------------------------------*/
    //this function verify account


    public function verifyAccount(VerifyAccountRequest $request){

        $otp = $request->validated();
        $user = Provider::where('otp_code',$otp);
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
        if($token = auth()->guard('developer')->attempt($login_data)){
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
        $user = Provider::where('phone',$phone)->first();
        // $user->notify(new ForgotPassOtpNotification());
        return response()->json(['status'=>'success','message'=>'an otp number sent to your phone number']);
    }

    /*----------------------------------------------------------------------------------------*/
        //code to reset password

    public function resetcode(ResetCodeRequest $request){

        $request->validated();
        $user = Provider::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone])->first();
        if($user->exists()){
            return response()->json(['status'=>'success','message'=>'code is valied']);
        }else{
            return response()->json(['status'=>'fail','message'=>'code is not valied']);
        }
    }
    /*---------------------------------------------------------------------------------------*/
        //to reset password

    public function resetpass(ResetPassRequest $request){

        $request->validated();
        $user = Provider::where('phone',$request->phone)->first();
        $user->update(['password'=>Hash::make($request->password)]);
        $user->tokens()->delete();

        return response()->json(['status'=>'success','message'=>'your passowrd is now changed successfully']);
    }


}





