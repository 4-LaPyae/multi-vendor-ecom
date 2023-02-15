<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //add to cart
    public function cartDataStore(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if ($product->discount_price == null) {
            Cart::add([
                'id' => $request->id,
                "name" => $request->product_name,
                "qty" => $request->quantity,
                "price" => $product->selling_price,
                "weight" => 1,
                'options' => [
                    'image' => $product->product_thambnail,
                    'color' => $request->color,
                    'size' => $request->size,
                ],

            ]);
            return response()->json(['success' => 'Successfully Added on Your Cart']);
        } else {
            Cart::add([
                'id' => $request->id,
                "name" => $request->product_name,
                "qty" => $request->quantity,
                "price" => $product->discount_price,
                "weight" => 1,
                'options' => [
                    'image' => $product->product_thambnail,
                    'color' => $request->color,
                    'size' => $request->size,
                ],

            ]);
            return response()->json(['success' => 'Successfully Added on Your Cart']);
        }
    }
    //end
    //add to cart with product detail
    public function detailcartDataStore(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if ($product->discount_price == null) {
            Cart::add([
                'id' => $request->id,
                "name" => $request->product_name,
                "qty" => $request->quantity,
                "price" => $product->selling_price,
                "weight" => 1,
                'options' => [
                    'image' => $product->product_thambnail,
                    'color' => $request->color,
                    'size' => $request->size,
                ],

            ]);
            return response()->json(['success' => 'Successfully Added on Your Cart']);
        } else {
            Cart::add([
                'id' => $request->id,
                "name" => $request->product_name,
                "qty" => $request->quantity,
                "price" => $product->discount_price,
                "weight" => 1,
                'options' => [
                    'image' => $product->product_thambnail,
                    'color' => $request->color,
                    'size' => $request->size,
                ],

            ]);
            return response()->json(['success' => 'Successfully Added on Your Cart']);
        }
    }
    //end

    //add mini cart
    public function AddMiniCart()
    {

        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal

        ));
    } // End Method

    //remove minicart prodcut in header 
    public function minicartProductRemove($rowId){
        Cart::remove($rowId);
        return response()->json(['success' => 'Product Remove From Cart']);
    }
    //end

    //mycart view
    public function myCart(){
        return view('frontend.mycart.mycart_view');
    }
    //end

    //get my cart
    public function getMyCart(){
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json([
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal

        ]);
    }
    //end

    //remove cart
    public function removeCart($rowId){
        Cart::remove($rowId);
        return response()->json(['success' => 'Successfully Remove From Cart']);
    }
    //end

    //decrement cart
    public function cartDecrement($rowId){
        $row = Cart::get($rowId);
       $cards = Cart::update($rowId, $row->qty -1);
        return response()->json($cards);
    }
    //end

    //decrement cart
    public function cartIncrement($rowId){
        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty +1);
        return response()->json('Increment');
    }

}
