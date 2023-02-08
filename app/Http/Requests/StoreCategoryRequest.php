<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            "category_name"=>"required",
            "category_image"=>"required|image|mimes:jpeg,png,jpg,gif,webp",
        ];
    }

    public function messages()
    {
        return [
            "category_name.required"=>"Category name is required!",
            "category_image.required"=>"Category image is required",
            "category_image.image"=>"Category image must be image",
            "category_image.mimes"=>"Category image should be jpeg,png,jpg,gif and webp"
        ];
    }
}
