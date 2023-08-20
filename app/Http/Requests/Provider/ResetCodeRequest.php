<?php

namespace App\Http\Requests\Provider;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class ResetCodeRequest extends ApiMasterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone'=>'required|exists:providers,phone',
            'country_code'=>'required|exists:users,country_code',
            'otp_code' =>'required|exists:providers,otp_code'
        ];

    }
}
