<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class VerifyAccountRequest extends ApiMasterRequest
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
            'otp_code'=>'required|exists:users,otp_code'
        ];
    }
}
