<?php

namespace App\Http\Controllers;

use App\Order;
use DateTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class StripeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Cart::count() <= 0) {
            return redirect()->route('products.index');
        }
        Stripe::setApiKey('sk_test_IByROLumbBpc01p7ghlBsWfw000TDF9S7B');

        $intent = PaymentIntent::create([
            'amount' => round(Cart::total()),
            'currency' => 'usd',
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);
        $clientSecret = Arr::get($intent, 'client_secret');

        return view('stripes.index',[
            'client_secret' => $clientSecret
        ]);
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
        
        
        $data = $request->json()->all();
        $order = new Order();
        
        $order->payment_intent_id = $data['payment_intent']['id'];
        $order->amount = $data['payment_intent']['amount'];
        $order->payment_created_at = (new DateTime())->setTimestamp($data['payment_intent']['created'])->format('d-m-y');
            $i =0;
            foreach (Cart::content() as $product) {
                $products['product_'.$i][] = $product->model->title;
                $products['product_'.$i][] = $product->model->description;
                $products['product_'.$i][] = $product->qty;
                $i++;
            }
        
        $order->products = serialize($products);
        $order->user_id = 15;
        $order->save();

        if($data['paymentIntent']['status'] == 'succeeded'){
            Cart::destroy();
            Session::flash('success', 'Votre Commande est traite avec success');
            return response()->json(['success' => 'Payment Intent Succedded']);
        } else {
            return response()->json(['success' => 'Payment Intent Not Succedded']);
        }
            
            

        Cart::destroy();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function thankyou()
    {
        return Session::has('success') ? view('stripes.thankyou') : redirect()->route('products.index');    
    }
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
}
