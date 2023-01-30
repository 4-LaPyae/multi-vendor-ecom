<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminLogin extends FormRequest
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
            'email' => 'required|string|email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            "email.required"=>"Email is required",
            "email.string"=>"Email must be string",
            "email.email"=>"email must be email",
            "password.required"=>"Password is required"
        ];
    }
}
