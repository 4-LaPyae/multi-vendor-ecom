<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
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
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        //
    }

    //add products to wishlist
    public function addProductWishlist(Request $request)
    {
        $product_id = $request->id;
        if (Auth::check()) {
            $existuser = Wishlist::where(
                [
                    ['user_id', Auth::id()],
                    ['product_id', $product_id]
                ]
            )->first();
            if (!$existuser) {
                Wishlist::insert([
                    "user_id" => Auth::id(),
                    "product_id" => $product_id,
                    "created_at" => Carbon::now()
                ]);
                return response()->json(['success' => 'Successfully Added On Your Wishlist']);
            } else {
                return response()->json(['error' => 'This Product Has Already on Your Wishlist']);
            }
        } else {
            return response()->json(['error' => 'At First Login Your Account']);
        }
    }
    //end

    //all wishlist
    public function allWishlist(){
        return view('frontend.wishlist.wishlist_view');
    }
    //end

    //get wishlist products
    public function getWishlistProduct(){
        $wishlist = Wishlist::with('products')->where('user_id',Auth::id())->latest()->get();
        $wishQty = wishlist::count();
        return response()->json([
            "wishlist"=>$wishlist,
            "wishQty"=>$wishQty
        ]);
    }
    //end

    //remove wishlist in header
    public function removeWishlist($id){
        $wishlist = Wishlist::where([
            ["user_id",Auth::id()],
            ["id",$id]
        ])->delete();
        return  response()->json(['success' => 'Successfully Product Remove']);
    }
    //end
}
