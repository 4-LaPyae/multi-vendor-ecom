<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{
    public function productDetails($id,$slug){
        $product = Product::findOrFail($id);
        $product_colours = explode(',',$product->product_color);
        $product_sizes = explode(',',$product->product_size);
        return view('frontend.product.product_details',compact('product','product_colours','product_sizes'));
        //var_dump($pro)

        //return view('frontend.product.category_view',compact('products','categories','breadcat'));
    }
}
