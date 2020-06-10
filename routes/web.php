<?php

use Illuminate\Support\Facades\Route;
use Gloudemans\Shoppingcart\Facades\Cart;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/search','ProductController@search')->name('products.search');
Route::resource('products','ProductController');
Route::resource('carts','CartController')->except('update');
Route::put('carts/{RowId}','CartController@update')->name('carts.update');
Route::get('vide',function (){
    return Cart::destroy();
});
Route::resource('stripes','StripeController');
Route::get("/merci" , 'StripeController@thankyou');
Route::get('/updated', 'CartController@updated');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
