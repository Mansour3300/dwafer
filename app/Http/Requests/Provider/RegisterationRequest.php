<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

class RegisterationRequest extends FormRequest
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
            'job_title'=>'required',
            'country'=>'required',
            'city'=>'required',
            'full_name'=>'required',
            'email'=>'required|email|unique:providers,email',
            'phone'=>'required|unique:providers,phone',
            'country_code'=>'required|exists:countries,country_code',
            'company_registeration_image'=>'mimes:jpeg,jpg,png,gif|max:1000',
            'provider_type'=>'required',
            'password'=>'required|confirmed|min:8',
            'sub_category_ids'=>'required|array'
        ];
    }
}
