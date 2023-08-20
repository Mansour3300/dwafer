<?php

namespace App\Http\Requests\Provider;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends ApiMasterRequest
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
            'bio'=>'required',
            'image'=>'required|mimes:jpeg,jpg,png,gif|max:1000'
        ];
    }
}
