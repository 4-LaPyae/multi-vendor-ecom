<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Compare;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compare  $compare
     * @return \Illuminate\Http\Response
     */
    public function show(Compare $compare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compare  $compare
     * @return \Illuminate\Http\Response
     */
    public function edit(Compare $compare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compare  $compare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compare $compare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compare  $compare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compare $compare)
    {
        //
    }

    //add to compare
    public function addToCompareProduct(Request $request){
        $product_id = $request->id;
        if(Auth::check()){

            $exit_user = Compare::where([
                ['user_id',Auth::id()],
                ['product_id',$product_id],
            ])->first();
           if(!$exit_user){
                Compare::insert([
                    'user_id'=>Auth::id(),
                    'product_id'=>$product_id,
                    'created_at'=>Carbon::now()
                ]);
                return response()->json(['success' => 'Successfully Added On Your Compare']);
            }else{
                return response()->json(['error' => 'This Product Has Already on Your Compare' ]);
            }
        }else{
            return response()->json(['error' => 'At First Login Your Account' ]);
        }
    }
    //end

    //compare list
    public function Compare(){
        return view('frontend.compare.compare_view');
    }
    //end
    //get compare list
    public function getCompare(){
        $compare = Compare::with('products')->where('user_id',Auth::id())->latest()->get();
        return response()->json($compare);
    }
    //end

    //remove compare
    public function removeCompare($id){
       $compare = Compare::where([
        ["user_id",Auth::id()],
        ["id",$id]
       ])->first();
       $compare->delete();
       return response()->json($compare);
    }
    //end
    
}
