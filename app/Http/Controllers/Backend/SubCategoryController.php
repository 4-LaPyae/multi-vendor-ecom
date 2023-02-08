<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;



class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories =  SubCategory::with(['category'])->latest()->get();
        return view('backend.subcategory.subcategory_all',compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('category_name','asc')->get();
        return view('backend.subcategory.subcategory_add',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubCategoryRequest $request)
    {
        $validator = $request->validated();
        $validator['subcategory_slug'] = Str::slug($validator['subcategory_name']);
        SubCategory::create($validator);
       $noti = [
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success'
       ];
        return redirect()->route('subcategories.index')->with($noti); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subcategory)
    {
        $categories = Category::orderBy('category_name','asc')->get();
        return view('backend.subcategory.subcategory_edit',compact('subcategory','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubCategoryRequest  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subcategory)
    {
       $validator = $request->validated();
       $validator['subcategory_slug'] = Str::slug($validator['subcategory_name']);
       $subcategory->update($validator);
       $noti = [
        'message' => 'SubCategory Updated Successfully',
        'alert-type' => 'success'
       ];
    return redirect()->route('subcategories.index')->with($noti); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        $noti =[
                'message' => 'Subcategory Deleted Successfully',
                'alert-type' => 'success'
                ];
        return redirect()->back()->with($noti); 
    }

    //get load subcategory for category
        //ajax get method
        public function getSubCategory($id){
        $subcategory = SubCategory::where('category_id',$id)->orderBy('subcategory_name','asc')->get();
            return json_encode($subcategory);
        }
        //ajax post method
        public function postSubCategory(Request $request){
            $subcategory = SubCategory::where('category_id',$request->id)->orderBy('subcategory_name','asc')->get();
        return response()->json($subcategory);
        }
    //end
}
