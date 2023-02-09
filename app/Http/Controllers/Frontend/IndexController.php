<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function Index(){
        //BEAUTY
        $skip_category_0 =  Category::skip(0)->first();
        $skip_product_0 = Product::where('status',1)
        ->where('category_id',$skip_category_0->id)
        ->orderBy('id','desc')
        ->get();
        //END
        //FASHION
        $skip_category_1 = Category::skip(1)->first();
        $skip_product_1 = Product::where('status',1)
        ->where('category_id',$skip_category_1->id)
        ->orderBy('id','desc')
        ->get();
        //END
        //ELECTRONIC
        $skip_category_2 = Category::skip(2)->first();
        $skip_product_2 = Product::where('status',1)
                        ->where('category_id',$skip_category_2->id)
                        ->orderBy('id','desc')
                        ->get();
        //END
        return view('frontend.index',compact('skip_category_0',
                    'skip_product_0','skip_category_1','skip_product_1',
                    'skip_category_2','skip_product_2'));
    }
    public function productDetails($id,$slug){
        $product = Product::findOrFail($id);
        $product_colours = explode(',',$product->product_color);
        $product_sizes = explode(',',$product->product_size);
        return view('frontend.product.product_details',compact('product','product_colours','product_sizes'));
        //var_dump($pro)

    }
}
