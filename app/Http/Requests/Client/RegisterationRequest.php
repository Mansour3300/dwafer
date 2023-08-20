<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterationRequest extends ApiMasterRequest
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
            'full_name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'phone'=>'required|unique:users,phone',
            'country_code'=>'required|exists:countries,country_code',
            'password'=>'required|confirmed|min:8'
        ];
    }
}
