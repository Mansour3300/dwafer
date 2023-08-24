<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends ApiMasterRequest
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
            'service_type'=>'required',// is it exist in subs or not will see
            'title'=>'required',
            'due_date'=>'required|date',
            'description'=>'required',
            'attachment'=>'file',
            'budget'=>'required',
            'provider_id'=>'nullable|exists:providers,id'
        ];
    }
}
