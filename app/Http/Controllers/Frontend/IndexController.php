<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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

        //HOT_DEALS
        $hot_deals = Product::where('hot_deals',1)
                    ->where('discount_price','!=',null)
                    ->where('status',1)
                    ->orderBy('id','desc')
                    ->get();
        //END
        //SPECIAL_OFFER
        $special_offer = Product::where('special_offer',1)
                        ->where('status',1)
                        ->orderBy('id','desc')
                        ->get();
        //END
        //NEW PRODUCT
        $new = Product::where('status',1)
                ->where('status',1)
                ->orderBy('id','desc')->limit(3)->get();
        //END

        //SPECIAL_DEALS
        $special_deals = Product::where('special_deals',1)
                            ->where('status',1)
                            ->orderBy('id','desc')->limit(3)->get();
        //EN
        return view('frontend.index',compact('skip_category_0',
                    'skip_product_0','skip_category_1','skip_product_1',
                    'skip_category_2','skip_product_2','hot_deals',
                    'special_offer','new','special_deals'));
    }
    public function productDetails($id,$slug){
        $product = Product::findOrFail($id);
        $product_colours = explode(',',$product->product_color);
        $product_sizes = explode(',',$product->product_size);
        return view('frontend.product.product_details',compact('product','product_colours','product_sizes'));
        //var_dump($pro)
    }

    //VENDOR DETAILS
    public function vendorDetails($id){
        $vendor = User::findOrFail($id);
        return view('frontend.vendor.vendor_details',compact('vendor'));
    }
    //END

    //VENDOR ALL
    public function vendorAll(){
         $vendors = User::with('products')
                        ->where([
                            ['status','active'],
                            ['role','vendor']
                        ])
                        ->orderBy('id','desc')
                        ->get();
        // $vendors = DB::table('users')
        //     ->join('products', 'users.id', '=', 'vendor_id')
        //     ->select('users.*', 'products.*')
        //     ->get();
            return view('frontend.vendor.vendor_all',compact('vendors'));

        //return $users;
    }
    //END

    //HEADER CATEGORY SHOW
    public function catHeaderProduct(Request $request,$id,$slug){
        $breadcat = Category::with('products')->where("id",$id)->first();
        $categories = Category::with('products')->orderBy('category_name','ASC')->get();
        $newproducts = Product::orderBy('id','desc')->limit(4)->get();
        return view('frontend.product.category_view',compact('breadcat','categories','newproducts')); 
    }
    //END

    //HEADER CATEGORY SHOW
    public function subcatHeaderProduct(Request $request,$id,$slug){
        $subcategories = SubCategory::with('products','category')->where('id',$id)->first();
        $categories = Category::orderBy('category_name','asc')->get();
        $newProduct = Product::orderBy('id','desc')->limit(3)->get();
        return view('frontend.product.subcategory_view',compact('subcategories','newProduct','categories'));
    }
    //END

    //PRODUCT VIEW MODEL WITH AJAX
    public function prodcutViewModel($id){
        $product = Product::with('category','brand')->findOrFail($id);
        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        return response()->json([
            "product"=>$product,
            "color"=>$product_color,
            "size"=>$product_size
        ]);

    }
    //END
}
