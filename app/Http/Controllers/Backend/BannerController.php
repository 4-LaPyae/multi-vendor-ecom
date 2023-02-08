<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Banner::latest()->get();
        return view('backend.banner.banner_all',compact('banner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.banner_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        $validator = $request->validated();
        $image = $validator['banner_image'];
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(768,450)->save('upload/banner/'.$name_gen);
        $save_url = 'upload/banner/'.$name_gen;
        $validator['banner_image']=$save_url;
        Banner::create($validator);
        $noti = [
            'message' => 'Banner Inserted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('banners.index')->with($noti); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('backend.banner.banner_edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, Banner $banner)
    {
        $validator = $request->validated();
        $old_img = $request->old_img;
        $image = $validator['banner_image'] ?? null;
      if($image){
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(768,450)->save('upload/banner/'.$name_gen);
        $save_url = 'upload/banner/'.$name_gen;

        if (file_exists($old_img)) {
           unlink($old_img);
        }
        $validator['banner_image'] = $save_url;
        $banner->update($validator);
        $noti = [
            'message' => 'Banner Updated with image Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('banners.index')->with($noti);
      }
      $banner->update($validator);
      $noti = [
        'message' => 'Banner Updated without image Successfully',
        'alert-type' => 'success'
    ];
    return redirect()->route('banners.index')->with($noti);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        unlink($banner->banner_image);
        $banner->delete();
        $noti = [
            'message' => 'Bannerd Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($noti); 
    }
}
