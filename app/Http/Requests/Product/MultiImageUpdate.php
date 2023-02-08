<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class MultiImageUpdate extends FormRequest
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
            "multi_img"=>"required|mimes:jpeg,png,jpg,gif,webp"
        ];
    }

    public function messages()
    {
        return[
            "multi_img.required"=>"Image File is required",
            "multi_img.mimes"=>"Image file is jpeg,png,jpg,gif and webp"
        ];
    }
}
