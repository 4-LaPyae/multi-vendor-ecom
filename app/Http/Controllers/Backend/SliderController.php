<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Image;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.slider_all',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.slider.slider_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        $validator = $request->validated();
        $image = $validator['slider_image'];
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(2376,807)->save('upload/slider/'.$name_gen);
        $save_url = 'upload/slider/'.$name_gen;
        $validator['slider_image']=$save_url;
        Slider::create($validator);
        $noti = [
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('sliders.index')->with($noti); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('backend.slider.slider_edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        $validator = $request->validated();
        $old_img = $request->old_img;
        $image = $validator['slider_image'] ?? null;
      if($image){
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(2376,807)->save('upload/slider/'.$name_gen);
        $save_url = 'upload/slider/'.$name_gen;

        if (file_exists($old_img)) {
           unlink($old_img);
        }
        $validator['slider_image'] = $save_url;
        $slider->update($validator);
        $noti = [
            'message' => 'Slider Updated with image Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('sliders.index')->with($noti);
      }
      $slider->update($validator);
      $noti = [
        'message' => 'Slider Updated without image Successfully',
        'alert-type' => 'success'
    ];
    return redirect()->route('sliders.index')->with($noti);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        unlink($slider->slider_image);
        $slider->delete();
        $noti = [
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($noti); 
    }
}
