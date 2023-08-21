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
                return response()->json(['status'=>'fail','data'=>null,'message'=>'company registeration image can not be empty']);

            }elseif($request->company_registeration_image!=null){
                $newuser['company_registeration_image']= $request->file('company_registeration_image')->store('image','public');
                $newuser['otp_code']=rand(0000,9999);
                Provider::create($newuser);
                foreach($request->sub_category_ids as $sub_category_id){
                    $provider = Provider::where('phone',$request->phone)->first();
                    $provider->developerSub()->attach($sub_category_id);
                }
                return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.auth.you_are_now_registered_as_a_company')]);
            }
        }elseif($newuser['provider_type']=='free_lancer'){
                $newuser['otp_code']=rand(0000,9999);
                Provider::create($newuser);
                foreach($request->sub_category_ids as $sub_category_id){
                    $provider = Provider::where('phone',$request->phone)->first();
                    $provider->developerSub()->attach($sub_category_id);
                }
                return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.auth.you_are_now_registered_as_a_freelancer')]);
        }

}
/*------------------------------------------------------------------------------------------*/
    //this function verify account


    public function verifyAccount(VerifyAccountRequest $request){

        $otp = $request->validated();
        $user = Provider::where('otp_code',$otp);
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
        if($token = auth()->guard('developer')->attempt($login_data)){
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
        $user = Provider::where('phone',$phone)->first();
        // $user->notify(new ForgotPassOtpNotification());
        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.auth.an_otp_number_sent_to_your_phone_number')]);
    }

    /*----------------------------------------------------------------------------------------*/
        //code to reset password

    public function resetcode(ResetCodeRequest $request){

        $request->validated();
        $user = Provider::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone])->first();
        if($user->exists()){
            return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.auth.code_is_valied')]);
        }else{
            return response()->json(['status'=>'fail','data'=>null,'message'=>trans('message.auth.code_is_not_valied')]);
        }
    }
    /*---------------------------------------------------------------------------------------*/
        //to reset password

    public function resetpass(ResetPassRequest $request){

        $request->validated();
        $user = Provider::where('phone',$request->phone)->first();
        $user->update([$request->password]);
        $user->tokens()->delete();

        return response()->json(['status'=>'success','data'=>null,'message'=>trans('message.auth.your_passowrd_is_now_changed_successfully')]);
    }


}





