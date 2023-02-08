<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
        // return [
        //     "brand_name"=>"required",
        //     "brand_image"=>"required|image|mimes:jpeg,png,jpg,gif,webp"
        // ];
        if (request()->isMethod('post')) {
            $rules = [
                "brand_name"=>"required",
                "brand_image"=>"required|image|mimes:jpeg,png,jpg,gif,webp"
            ];
        } elseif (request()->isMethod('PUT')) {
            $rules = [
                "brand_name" => "required|unique:brands,brand_name,".$this->user()->id,
                "brand_image"=>"nullable"
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            "brand_name.required"=>"Brand name is required!",
            "brand_image.required"=>"Brand image is required",
            "brand_image.image"=>"Brand image must be image",
            "brand_image.mimes"=>"Brand image should be jpeg,png,jpg,gif and webp",
            "brand_name.unique"=>"New brand name must not be same with original brand name"
        ];
    }
}
