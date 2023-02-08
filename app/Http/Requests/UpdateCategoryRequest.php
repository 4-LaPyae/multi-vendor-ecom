<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            "category_name" => "required|unique:categories,category_name,".$this->user()->id,
            "category_image"=>"nullable"
        ];
    }

    public function messages()
    {
        return [
            "category_name.required"=>"Category name is required!",
            "category_name.unique"=>"New category name must not be same with original category name"
        ];
    }
}
