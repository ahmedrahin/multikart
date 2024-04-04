<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Cupon;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderVariation;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;

class CartController extends Controller
{
    public function manage(){
        if( Auth::check() ){
            $carts = Cart::where('user_id', Auth::id())->where('order_id', NULL)->first();
        }else{
            $carts = Cart::where('ip_address', request()->ip())->where('order_id', NULL)->first();
        }
        return view('frontend.pages.order.cart', (['carts' => $carts]));
    }

    public function store(Request $request){
        $form = [];
        parse_str($request->input('newform'), $form);

        // Extract specific data
        $productId = $form['productId'] ?? null;
        $quantity = $form['quantity'] ?? null;
        $variationIds = $request->input('variation_id');

        // check user has been log in or not
        if( Auth::check() ){
            $cart = Cart::where('user_id', Auth::id())->where('product_id', $productId)->where('order_id', NULL)->first();
        } else{
            $cart = Cart::where('ip_address', request()->ip())->where('product_id', $productId)->where('order_id', NULL)->first();
        }

        // if the product alerady has been cart increment the product quantity
        if( !is_null( $cart ) ){
            $newQuantity = $cart->product_quantity + $quantity;
            $cart->update(['product_quantity' => $newQuantity]);
            $cart->save();

            return response()->json([
                'html' => view('frontend.includes.cartItem')->render(),
                'msg' => 'Item Quantity Updated Into Cart',
            ]);
        }else {
            $cart = new Cart();
            if( Auth::check() ){
                $cart->user_id = Auth::id();
            }
            
            $cart->ip_address        = request()->ip();
            $cart->product_id        = $productId;
            $cart->product_quantity  = $quantity;
            $cart->save();

            // order variation
            if(!empty($variationIds))
            {
                foreach($variationIds as $variation)
                {
                    $OrderVariation = new OrderVariation;
                    $OrderVariation->cart_id = $cart->id;
                    $OrderVariation->product_id = $productId;
                    $OrderVariation->var_val_id = $variation;
                    $OrderVariation->save();
                }
            }
            
            return response()->json([
                'html' => view('frontend.includes.cartItem')->render(),
                'msg' => 'The Item Added Into Cart',
            ]);
        }
    }

    public function addToCart(Request $request){
        // check user has been log in or not
        if( Auth::check() ){
            $cart = Cart::where('user_id', Auth::id())->where('product_id', $request->productId)->where('order_id', NULL)->first();
        } else{
            $cart = Cart::where('ip_address', request()->ip())->where('product_id', $request->productId)->where('order_id', NULL)->first();
        }

        // if the product alerady has been cart increment the product quantity
        if( !is_null( $cart ) ){
            $newQuantity = $cart->product_quantity + $request->quantity;
            $cart->update(['product_quantity' => $newQuantity]);

            $cart->save();
            return response()->json([
                'html' => view('frontend.includes.cartItem')->render(),
                'msg' => 'Item Quantity Updated Into Cart',
            ]);
        }else {
            $cart = new Cart();
            if( Auth::check() ){
                $cart->user_id = Auth::id();
            }
            
            $cart->ip_address        = request()->ip();
            $cart->product_id        = $request->productId;
            $cart->product_quantity  = $request->quantity;

            $cart->save();
            return response()->json([
                'html' => view('frontend.includes.cartItem')->render(),
                'msg' => 'The Item Added Into Cart',
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(int $id)
    {
        $delete = Cart::findorFail($id);
        if( !is_null( $delete ) ){
            $delete->delete();
            return response()->json([
                'html' => view('frontend.includes.cartItem')->render(),
                'delWc' => view('frontend.includes.wishlistDetails')->render(),
                'cartItem' => view('frontend.pages.order.cartItem')->render(),
                'msg' => 'The Item Remove Form Cart',
            ]);
        }
    }

    // coupon apply
    public function applyDiscount(Request $request){
        $code = Cupon::where('cupon_code', $request->code)->first();
    
        if( $code == null ){
            return response()->json([
                'status' => false,
                'message' => "The Coupon Code is Invalid"
            ]);
        }
        
        $now = Carbon::now();
        if( $code->start_at != '' ){
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->start_at);
            if($now->lt($startDate)){
                return response()->json([
                    'status' => false,
                    'message' => "The Coupon Code is Expired"
                ]);
            }
        }
    
        if( $code->expires_at != '' ){
            $expireDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->expires_at);
            if($now->gt($expireDate)){
                return response()->json([
                    'status' => false,
                    'message' => "The Coupon Code is Expired"
                ]);
            }
        }

        // how many time use
        $couponUsed = Order::where('cupon_code', $code->cupon_code)->count();
        if( (!is_null($code->max_uses)) && ($couponUsed >= $code->max_uses) ){
            return response()->json([
                'status' => false,
                'message' => "The Coupon is not available"
            ]);
        }

        // how many time user use
        $couponUsedUser = Order::where(['cupon_code' => $code->cupon_code, 'user_id' => Auth::user()->id])->count();
        if( (!is_null($code->max_uses_user)) && ($couponUsedUser >= $code->max_uses_user) ){
            return response()->json([
                'status' => false,
                'message' => "You already used this coupon"
            ]);
        }

        // minmum amount
        $totalCartAmount = Cart::totalAmount();
        if( (!is_null($code->min_amount)) && ($totalCartAmount <= $code->min_amount) ){
            return response()->json([
                'status' => false,
                'message' => "Your min amount must be ৳" . $code->min_amount
            ]);
        }
    
        // Store coupon code in the session
        session()->put('code', $code);
    
        // Calculate discount and update session
        $discountAmount = Cart::discountAmount()['discount'];
        $discountedTotalAmount = Cart::discountAmount()['totalAmount'] - $discountAmount;

        session()->put('discount', [
            'discount' => $discountAmount,
            'discountedTotalAmount' => $discountedTotalAmount
        ]);

        // Return the response with the stored discount information
        return response()->json([
            'status' => true,
            'discount' => $discountAmount,
            'discountedTotalAmount' => $discountedTotalAmount
        ]);
    }
    
    // delete coupon
    public function delCoupon(){
        session()->forget('code');
        session()->forget('discount');
    }
    
}








// // check user has been log in or not
// if( Auth::check() ){
//     $cart = Cart::where('user_id', Auth::id())->where('product_id', $request->productId)->where('order_id', NULL)->first();
// } else{
//     $cart = Cart::where('ip_address', request()->ip())->where('product_id', $request->productId)->where('order_id', NULL)->first();
// }

// // if the product alerady has been cart increment the product quantity
// if( !is_null( $cart ) ){
//     $newQuantity = $cart->product_quantity + $request->quantity;
//     $cart->update(['product_quantity' => $newQuantity]);

//     // product quantity has been increase
//     session()->flash('alert-type', 'success');
//     session()->flash('message', 'Item Quantity Updated Into Cart');
//     $cart->save();
//     return redirect()->back();
// }else {
//     $cart = new Cart();
//     if( Auth::check() ){
//         $cart->user_id = Auth::id();
//     }
    
//     $cart->ip_address        = request()->ip();
//     $cart->product_id        = $request->productId;
//     $cart->product_quantity  = $request->quantity;

//     // product save into the cart
//     session()->flash('alert-type', 'success');
//     session()->flash('message', 'The Item Added Into Cart');
//     $cart->save();
//     return redirect()->route('checkout');
// }