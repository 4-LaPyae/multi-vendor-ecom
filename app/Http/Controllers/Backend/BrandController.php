<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Support\Str;
use Image;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('backend.brand.brand_all',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.brand.brand_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBrandRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $validator = $request->validated();
        $image = $validator['brand_image'];;
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
        $save_url = 'upload/brand/'.$name_gen;

        $validator['brand_slug'] = Str::slug($validator['brand_name']);
        $validator['brand_image'] = $save_url;
        Brand::create($validator);
       $noti =[
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
       ];

        return redirect()->route('brands.index')->with($noti);  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('backend.brand.brand_edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBrandRequest  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBrandRequest $request, Brand $brand)
    {
        $validator = $request->validated();
        $old_image = $brand->brand_image;
        $image = $validator['brand_image'] ?? null;
        if($image){
                    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                    Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
                    $save_url = 'upload/brand/'.$name_gen;
                        if(file_exists($old_image)){
                                unlink($old_image);
                            }
                    $validator['brand_image'] = $save_url;
                    $validator['brand_slug'] =Str::slug($validator['brand_name']) ;
                    $brand->update($validator);
                    $noti =[
                        'message' => 'Brand Updated with image Successfully',
                        'alert-type' => 'success'
                            ];
            return redirect()->route('brands.index')->with($noti); 
        }
        
        $validator['brand_slug'] =Str::slug($validator['brand_name']) ;
        $brand->update($validator);
        $noti =[
                'message' => 'Brand Updated without image Successfully',
                'alert-type' => 'success'
                ];
        return redirect()->route('brands.index')->with($noti);  
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        unlink($brand->brand_image);
        $noti =[
                'message' => 'Brand Deleted Successfully',
                'alert-type' => 'success'
                ];
        return redirect()->back()->with($noti); 
    }
}
