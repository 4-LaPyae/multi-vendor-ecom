<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class VendorRegister extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|unique:users',
            'phone'=>'nullable',
            'username'=>"required|string",
            'password' => 'required|min:8',
            'password_confirmation'=>'required|same:password'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be string',
            'email.required'=> 'Email is required',
            'email.string'=>'Email must be string',
            'email.email'=>'Email must be email',
            'email.unique'=>'Email have already exists!',
            'password.required'=>'Password is required',
            'password.min'=>'The password must be at least 8 characters.',
            'password_confirmation.required'=>'Confirm password is required',
            'password_confirmation.same'=>'Your password must be same'
        ];
    }
}
