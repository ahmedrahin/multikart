<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ProductpagesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// category or subcategory api
Route::middleware('isAdmin')->group(function(){
    Route::get("get-subcategory/{id}", function($id){
        return json_encode(App\Models\Subcategory::orderBy('name', 'asc')->where("category_id", $id)->where("status", 1)->get());
    });
});

// variation api
Route::get('get-option/{id}', function($id){
    return json_encode(App\Models\VariationValue::orderBy('option', 'asc')->where('var_id', $id)->get());
});

// country state or district api
Route::get('get-state/{id}', function($id){
    return json_encode(App\Models\State::orderBy('name', 'asc')->where('country_id', $id)->where("status", 1)->get());
    return json_encode(App\Models\District::orderBy('name', 'asc')->where('country_id', $id)->where("status", 1)->get());
});
Route::get('get-district/{id}', function($id){
    return json_encode(App\Models\District::orderBy('name', 'asc')->where('state_id', $id)->where("status", 1)->get());
});

// product images api
Route::get('get-images/{id}', function($id){
    return json_encode(App\Models\ImageGallery::where('product_id', $id)->get());
});

// searh box api
Route::get('search-product', [ProductpagesController::class, 'ajaxsearchProduct']);
// cart item
Route::get('get-cart/{id}', function($id){
    return json_encode(App\Models\Cart::where('id', $id)->get());
});

// api for shipping method
Route::get('get-method/{id}', function($id){
    return json_encode(App\Models\Shipping::where('base_id', $id)->first());
});

Route::get('get-qriour', function(){
    return json_encode(App\Models\Shipping::where('base_id', null)->get());
});
