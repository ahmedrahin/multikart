<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\District;
use App\Models\Country;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\ToastrServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use File;
use Image;
use Auth;

class DashboardController extends Controller
{
    
    public function user_dashboard()
    {   
        $userId    = Auth::user()->id;
        $user      = User::where('id', $userId)->first();
        $orders    = Order::orderBy('id', 'desc')->where('user_id', $user->id)->get();
        $wishlists = Wishlist::orderBy('id', 'desc')->where('user_id',  $user->id)->get();
        return view('frontend.pages.customer-pages.dashboard', compact('user', 'orders', 'wishlists'));
    }

    public function order_invoice(string $id){
        $order_invoice = Order::find($id);
        $orders  = Order::where('id', $order_invoice->id)->first();
        $items   = Cart::where('order_id', $orders->id)->get();
        return view('frontend.pages.order.invoice', compact('orders', 'items'));
    }

    public function user_profile()
    {   
        $country  = Country::orderBy('name', 'asc')->where('status', 1)->get();
        $state    = State::orderBy('name', 'asc')->where('status', 1)->get();
        $district = District::orderBy('name', 'asc')->where('status', 1)->get();
        return view('frontend.pages.customer-pages.profile', compact('country', 'state', 'district'));
    }

    public function forget_password()
    {
        return view('frontend.pages.auth-user.forget-password');
    }

    /**
     * Update the user information.
     */
    public function userInfo(Request $request, string $id)
    {
        $userInfo = User::find($id);

        if( !is_null( $userInfo ) ){
            // validation
            $request->validate([
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($userInfo->id),
                    function ($attribute, $value, $fail) {
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $fail('The '.$attribute.' must be a valid email address.');
                        }
                    },
                ],
                'phone' => 'nullable|numeric',
            ]);

            $userInfo->name = $request->name;
            $userInfo->email = $request->email;
            $userInfo->phone = $request->phone;

            // Notification
            Toastr::success('Your Information is Updated', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            $userInfo->save();
            return redirect()->route('user-profile');
        }

    }
    
    /**
     * Update the user shipping information.
     */
    public function shippingInfo(Request $request, string $id)
    {
        $shippingInfo = User::find($id);

        if( !is_null( $shippingInfo ) ){

            $shippingInfo->address_line1 = $request->address_line_1;
            $shippingInfo->address_line2 = $request->address_line_2;
            $shippingInfo->zipCode       = $request->zip_code;
            $shippingInfo->country_id    = $request->country_id;
            $shippingInfo->division_id   = $request->division_id;
            $shippingInfo->district_id   = $request->district_id;

            // Notification
            Toastr::success('Shipping Information Updated', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            $shippingInfo->save();
            return redirect()->route('user-profile');
        }

    }

    /**
     * Set user profile picture
     */
    public function profilePic(Request $request, string $id)
    {
        $userImg = User::find($id);
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg,gif',    
        ]);

        $uploadedImage = $request->file('image');
        $hadProfilePic = !empty($userImg->image);

        if ($uploadedImage) {
            // Remove the previous image from storage
            if ($hadProfilePic && File::exists(public_path('uploads/user/' . $userImg->image))) {
                File::delete(public_path('uploads/user/' . $userImg->image));
            }

            $imageName     = time() . '-user.' . $uploadedImage->getClientOriginalExtension();
            $imageLocation = public_path('uploads/user/' . $imageName);

            // Save the uploaded image
            Image::make($uploadedImage)->save($imageLocation);
            $userImg->image = $imageName;

            if ($hadProfilePic) {
                Toastr::success('Profile Picture is Updated', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            } else {
                Toastr::success('Profile Picture is Uploaded', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            }
        } else {
            Toastr::error('Profile Picture is Not Uploaded', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
        }

        $userImg->save();
        return redirect()->route('user-profile');
    }

    /**
     * Remove the user profile picture.
     */
    public function removeProfilePic(Request $request, string $id){

        $remove_img = User::find($id);

        if (!is_null($remove_img)) {
            $hadProfilePic = !empty($remove_img->image);

            if ($hadProfilePic && $request->has('remove_image')) {
                // Remove the image from storage
                if (File::exists(public_path('uploads/user/' . $remove_img->image))) {
                    File::delete(public_path('uploads/user/' . $remove_img->image));
                }

                // Remove the image reference from the database
                $remove_img->image = null;

                // Notification
                Toastr::error('Profile Picture is Removed', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
                $remove_img->save();
                return redirect()->back();
            }
        }
    }

    /**
     * Remove the specified user.
     */
    public function profileDestroy(string $id)
    {
        $del_account = User::find($id);
        $del_account->delete();
        session::flash('alert-type', 'error');
        session::flash('message', 'Your Account has been Destroy');
        return redirect('/');
    }

    // deactive account
    public function deactiveAccount(string $id)
    {
        $deactive_account = User::find($id);
        $deactive_account->update(['status' => 0]);
        $deactive_account->save();
        session::flash('alert-type', 'error');
        session::flash('message', 'Your Account has been Deactive');
        return redirect('/');
    }
   
}
