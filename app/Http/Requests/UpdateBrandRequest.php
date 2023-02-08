<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
            "brand_name" => "required|unique:brands,brand_name,".$this->route('brand')->id,
            "brand_image"=>"nullable"
        ];
    }

    public function messages()
    {
        return [
            "brand_name.required"=>"Brand name is required!",
            "brand_name.unique"=>"New brand name must not be same with original brand name"
        ];
    }
}
