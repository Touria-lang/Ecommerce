<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('carts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $product = Product::find($request->id);
        
        $duplicata = Cart::search(function($cartItem,$rowId) use($product){
            return $cartItem->id == $product->id;
        }
        );
        if($duplicata->isnotEmpty()){
            return redirect()->route('products.index')->with('success','Le produit a deja ete ajoutee!'); 
        }

        Cart::add($request->id,$product->title,1,$product->price)
        ->associate('App\Product');
        

        return redirect()->route('products.index')->with('success','msg ajoutee correctement');
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
    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();
        Cart::update($rowId, ['qty' => $data['qty']]);
        Session::flash('success', 'la quantite du produit est passse a ' . $data['qty'] . '.');
        return response()->json('success', 'Cart quantity has been updated');
    }
    public function updated(){
        Session::has('success') ? dd('hello') : redirect()->route('carts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        return back()->with('success','Msg supprimee');
    }
}
