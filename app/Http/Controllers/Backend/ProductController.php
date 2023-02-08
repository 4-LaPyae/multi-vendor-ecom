<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Http\Requests\Product\MultiImageUpdate;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImage;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_all', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activeusers = User::where('status', 'active')->where('role', 'vendor')->latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        return view('backend.product.product_add', compact('brands', 'categories', 'subcategories', 'activeusers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validator = $request->validated();
        $image = $validator['product_thambnail'];
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/products/thambnail/'.$name_gen);
        $save_url = 'upload/products/thambnail/'.$name_gen;
        $validator['product_slug'] = Str::slug($validator['product_name']);
        $validator['product_thambnail'] = $save_url;
        $validator['status'] = 1;
        $validator['created_at'] = Carbon::now();
        $product = Product::create($validator);
        
        // Multiple Image Upload From product
        $images = $validator['multi_img'];
        foreach($images as $img){
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
            $uploadPath = 'upload/products/multi-image/'.$make_name;
            MultiImage::insert([
            'product_id' => $product->id,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(), 
        ]); 
        } // end foreach
        $notification = [
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('products.index')->with($notification); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {   
        $activeVendor = User::where('status','active')->where('role','vendor')->latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        return view('backend.product.product_edit',compact('brands','categories','activeVendor','product','subcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validator = $request->validated();
        $validator['status'] = 1;
        $validator['created_at'] = Carbon::now();
        $product->update($validator);
        $noti = [
            "message"=>"product update without image successfully",
            "alert-type"=>"success"
        ];
        return redirect()->route('products.index')->with($noti);
    }

    //UPDAE MAIN IMAGE THAMBNAIL
        public function updateThambnail(Request $request){
            $id = $request->id;
            $old_image = $request->old_image;
            $product = Product::findOrFail($id);
            $image = $request->file('product_thambnail');
            if($image){
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(800,800)->save('upload/products/thambnail/'.$name_gen);
                $save_url = 'upload/products/thambnail/'.$name_gen;
                //old image delete
                if(file_exists($old_image)){
                    unlink($old_image);
                }
                //end
                $product->update([
                    "product_thambnail"=>$save_url,
                    "created_at"=> Carbon::now()
                ]);
            }
            $noti = [
                "message"=>"Product Image Thambnail Updated Successfully",
                "alert-type"=>"success"
            ];
            return redirect()->back()->with($noti);
        }
    //END

    //UPDATE MULTI IMAGES
    public function updateMultiImages(Request $request){
        $images = $request->multi_img;
        if($images){
            foreach ($images as $id => $img) {
             $delImage = MultiImage::find($id);
             unlink($delImage->photo_name);
             $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
            $uploadPath = 'upload/products/multi-image/'.$make_name;
            MultiImage::where('id',$id)->update([
                "photo_name"=>$uploadPath,
                "created_at"=>Carbon::now()
            ]);
            }
            $noti = [
                'message' => 'Product Multi Image Updated Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($noti); 
        }else{
            return redirect()->back();
        }       
    }
    //END


    //DELETE MULTI IMAGES IN MULTIIMAGE TABLE 
    public function deleteMultiImage($id){
        $old_image = MultiImage::findOrFail($id);
        unlink($old_image->photo_name);
        $old_image->delete();
        $noti = [
            'message' => 'Product Multi Image Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($noti);
    }
    //END

    //PRODUCT INACTIVE
     public function productInActive($id){
        $product = Product::findOrFail($id);
        $product->update(['status'=>0]);
        $noti = [
            'message' => 'Product Inactive',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($noti);   
     }
    //END

    //PRODUCT ACTIVE
    public function productActive($id){
        $product = Product::findOrFail($id);
        $product->update(['status'=>1]);
        $noti = [
            'message' => 'Product Active',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($noti);   
     }
    //END

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {   
        //delete main image in product table
        unlink($product->product_thambnail);
        //end
        $images = MultiImage::where('product_id',$product->id)->get();
        $product->delete();
        foreach ($images as $img) {
        //delete multi images in multi image table
        unlink($img->photo_name);
        //end
          MultiImage::find($img->id)->delete();
        }
        $noti =[
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($noti);
    }
}
