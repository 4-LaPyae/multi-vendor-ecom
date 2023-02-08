<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
    public function rules(){
        if(request()->isMethod('post')){
            $rules = [
                "banner_title"=>"required|string",
                "banner_url"=>"required|string",
                "banner_image"=>"required|mimes:jpeg,png,jpg,gif,webp"
            ];
        }elseif(request()->isMethod('put')){
            $rules = [
                "banner_title"=>"required|string",
                "banner_url"=>"required|string",
                "banner_image"=>"nullable"
            ];
        }
        return $rules;
    }
    
    public function messages()
    {
        return [
            "banner_title.required"=>"Banner Title is required",
            "banner_title.string"=>"Banner Title must be string",
            "banner_url.required"=>"Banner Url is required",
            "banner_url.string"=>"Banner Url must be string",
            "banner_image.required"=>"Select Image file",
            "banner_image.mimes"=>"File type must be jpeg,png,jpg,gif and webp"
        ];
    }
}
