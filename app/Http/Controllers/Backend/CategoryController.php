<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id','desc')->get();
        return view('backend.category.category_all',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.category.category_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $validator = $request->validated();
        $image = $validator['category_image'];;
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(120,120)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;
        $validator['category_slug'] = Str::slug($validator['category_name']);
        $validator['category_image'] = $save_url;
        Category::create($validator);
       $noti =[
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
       ];

        return redirect()->route('categories.index')->with($noti);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('backend.category.category_edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validator = $request->validated();
        $old_image = $category->category_image;
        $image = $validator['category_image'] ?? null;
        if($image){
                    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                    Image::make($image)->resize(120,120)->save('upload/category/'.$name_gen);
                    $save_url = 'upload/category/'.$name_gen;
                        if(file_exists($old_image)){
                                unlink($old_image);
                            }
                    $validator['category_image'] = $save_url;
                    $validator['category_slug'] = Str::slug($validator['category_name']);
                    $category->update($validator);
                    $noti =[
                        'message' => 'Category Updated with image Successfully',
                        'alert-type' => 'success'
                            ];
            return redirect()->route('categories.index')->with($noti); 
        }
        
        $validator['category_slug'] =Str::slug($validator['category_name']) ;
        $category->update($validator);
        $noti =[
                'message' => 'Category Updated without image Successfully',
                'alert-type' => 'success'
                ];
        return redirect()->route('categories.index')->with($noti);  
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        unlink($category->category_image);
        $noti =[
                'message' => 'Category Deleted Successfully',
                'alert-type' => 'success'
                ];
        return redirect()->back()->with($noti); 
    }
}
