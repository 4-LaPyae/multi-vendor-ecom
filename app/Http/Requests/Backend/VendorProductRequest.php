<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class VendorProductRequest extends FormRequest
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
                "product_name"=>"required",
                "short_descp"=>"required",
                "long_descp"=>"required",
                "product_tags"=>"nullable",
                "product_size"=>"nullable",
                "product_color"=>"nullable",
                "product_thambnail"=>"required",
                "multi_img"=>"required",
                "selling_price"=>"required",
                "discount_price"=>"nullable",
                "product_code"=>"required",
                "product_qty"=>"required",
                "brand_id"=>"required",
                "category_id"=>"required",
                "subcategory_id"=>"required",
                "hot_deals"=>"nullable",
                "featured"=>"nullable",
                "special_offer"=>"nullable",
                "special_deals"=>"nullable"
    
            ];
        }elseif (request()->isMethod('put')){
                 $rules = [
                "product_name"=>"required",
                "short_descp"=>"required",
                "long_descp"=>"required",
                "product_tags"=>"nullable",
                "product_size"=>"nullable",
                "product_color"=>"nullable",
                "selling_price"=>"required",
                "discount_price"=>"nullable",
                "product_code"=>"required",
                "product_qty"=>"required",
                "brand_id"=>"required",
                "category_id"=>"required",
                "subcategory_id"=>"required",
                "hot_deals"=>"nullable",
                "featured"=>"nullable",
                "special_offer"=>"nullable",
                "special_deals"=>"nullable"
            ];
                
        }
        return $rules;
        
    }
    public function messages()
    {
        return [
            "product_name.required"=>"Please Enter Product Name",
            "short_descp.required"=>"Please Enter Short Description",
            "long_descp.required"=>"Please Enter Long Description",
            "product_thambnail.required"=>"Please Select Product Thambnail Image",
            "multi_img.required"=>"Please Select Product Multi Image",
            "selling_price.required"=>"Please enter selling price",
            "product_code.required"=>"Please enter product code",
            "product_qty.required"=>"Please enter product quantity",
            "brand_id.required"=>"Please select brand",
            "category_id.required"=>"Please select category",
            "subcategory_id.required"=>"Please select subcategory",
        ];
    }
}
