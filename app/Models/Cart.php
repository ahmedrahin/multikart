<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_quantity',
        'prdtc_unt_pri',
        'order_id',
        'user_id',
        'ip_address'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    // how many items in the cart
    public static function totalQunt(){
        $totalQunt = 0;
        if( Auth::check() ){
            $carts = Cart::where('user_id', Auth::id())->where('order_id', NULL)->get();
        }else {
            $carts = Cart::where('ip_address', request()->ip())->where('order_id', NULL)->get();
        }

        foreach( $carts as $cart ){
           if( $cart->product->status == 1 ){
                $totalQunt += $cart->product_quantity;
           }
        }
        if(  $totalQunt == 0 ){
            session()->forget('code');
             session()->forget('discount');
         }
        return $totalQunt;
    }

    // how many product in the cart
    public static function totalItems(){
        if( Auth::check() ){
            $carts = Cart::where('user_id', Auth::id())->where('order_id', NULL)->get();
        }else {
            $carts = Cart::where('ip_address', request()->ip())->where('order_id', NULL)->get();
        }
        return $carts;
    }

    // total amount
    public static function totalAmount(){
        $totalAmount = 0;
        if( Auth::check() ){
            $carts = Cart::where('user_id', Auth::id())->where('order_id', NULL)->get();
        }else {
            $carts = Cart::where('ip_address', request()->ip())->where('order_id', NULL)->get();
        }
        
        foreach( $carts as $cart ){
            if( $cart->product->status == 1 ){
                if( !is_null( $cart->product->offer_price ) ){
                    $totalAmount += $cart->product_quantity * $cart->product->offer_price ;
                }
                else{
                    $totalAmount += $cart->product_quantity * $cart->product->regular_price ;
                }
            }
        }
        return $totalAmount;
    }

    public static function discountAmount(){
        $totalAmount = Cart::totalAmount();
        $discount = 0;
        $discountedTotalAmount = $totalAmount;
    
        if (session()->has('code')) {
            $code = session()->get('code');
            if ($code->type == 'percent') {
                $discount = ($code->discount_amount / 100) * $totalAmount;
            } else {
                $discount = $code->discount_amount;
            }
            $discountedTotalAmount = $totalAmount - $discount;
        }

        if(  Cart::totalItems()->count() == 0 ){
            session()->forget('code');
            session()->forget('discount');
         }
    
        // Store discount information in the session
        session()->put('discount', [
            'discount' => $discount,
            'discountedTotalAmount' => $discountedTotalAmount
        ]);
    
        return ['totalAmount' => $discountedTotalAmount, 'discount' => $discount];
    } 
    
    public function OrderVariation()
    {
        return $this->hasMany(OrderVariation::class);
    }

}
