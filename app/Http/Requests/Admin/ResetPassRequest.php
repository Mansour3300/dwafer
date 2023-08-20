<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class ResetPassRequest extends ApiMasterRequest
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
            'password'=> 'required|min:8|confirmed',
            'phone' => 'required|exists:users,phone',
            'country_code'=>'required|exists:users,country_code'
        ];
    }
}
