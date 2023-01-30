<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserDetail extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [ 
                "name"=>"required",
                "username"=>"required",
                "email"=>"required",
                "phone"=>"nullable",
                "address"=>"nullable",
                "vendor_join"=>"nullable",
                "vendor_short_info"=>"nullable",
                "photo"=>"nullable"
        ];
    }

    public function messages()
    {
        return [
            "name.required"=>"Name is required",
            "username.required"=>"Username is required",
            "email.required"=>"Email is required",             
        ];
    }
}
