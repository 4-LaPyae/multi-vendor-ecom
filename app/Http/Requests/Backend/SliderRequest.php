<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        if(request()->isMethod('post')){
            $rules = [
                "slider_title"=>"required|string",
                "short_title"=>"required|string",
                "slider_image"=>"required|mimes:jpeg,png,jpg,gif,webp"
            ];
        }elseif(request()->isMethod('put')){
            $rules = [
                "slider_title"=>"required|string",
                "short_title"=>"required|string",
                "slider_image"=>"nullable"
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            "slider_title.required"=>"Slider Title is required",
            "slider_title.string"=>"Slider Title must be string",
            "short_title.required"=>"Short Title is required",
            "short_title.string"=>"Short Title must be string",
            "slider_image.required"=>"Select Image file",
            "slider_image.mimes"=>"File type must be jpeg,png,jpg,gif and webp"
        ];
    }
}
