<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Mail\newOrderEmail;
use App\Mail\newOrderCustomerEmail;
use Carbon\Carbon;
use Auth;
use DB;
use Mail;

class SslCommerzPaymentController extends Controller
{

    public function checkout()
    {
        $countries  = Country::orderBy('name', 'asc')->where('status', 1)->get();
        $states     = State::orderBy('priority_number', 'asc')->where('status', 1)->get();
        $districts  = District::orderBy('name', 'asc')->where('status', 1)->get();
        return view('frontend.pages.order.checkout', ["countries" => $countries, "states" => $states, "districts" => $districts]);
    }

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        // Validation
        $request->validate([
            "name"              => "required",
            'email'             => 'required',         
            'phone'             => "required|numeric",
            'address_line1'     => "required",
            'country'           => "required",
            'state'             => "required",
            'district'          => "required",
            'zipCode'           => "required",
        ]);

        $post_data = array();
        $post_data['total_amount']  = Cart::totalAmount(); 
        $post_data['paid_amount']   = Cart::discountAmount()['totalAmount']; 
        $post_data['discount_amount'] = Cart::discountAmount()['discount']; 
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name']      = $request->name;
        $post_data['cus_email']     = $request->email;
        $post_data['cus_phone']     = $request->phone;
        $post_data['cus_add1']      = $request->address_line1;
        $post_data['cus_add2']      = $request->address_line2;
        $post_data['cus_country']   = $request->country;
        $post_data['cus_state']     = $request->state;
        $post_data['cus_district']  = $request->district;
        $post_data['cus_postcode']  = $request->zipCode;
        $post_data['coupon_code']   = $request->code;
        $post_data['cus_fax']       = "";
        $post_data['paymentMethod'] = $request->paymentMethod;
        // manage shipping method & charge
        $post_data['shipping_method'] = $request->shipping;

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        if( Auth::check() ){
            $userId = Auth::user()->id;
        }else {
            // notification
            session()->flash('alert-type', 'warning');
            session()->flash('message', 'You must be Login for Checkout');
            return redirect()->back();
        }
        
        // set time
        Carbon::setLocale('en');
        $currentTime = Carbon::now();
        $currentTime->setTimezone('Asia/Dhaka');
        $createdAt = $currentTime->format('M-d-y h:i a');
        $order_date = $currentTime->format('M-d-y');

        #Before  going to initiate the payment order status need to insert or update as Pending.
        if( $post_data['paymentMethod'] == 1 ){
            $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'user_id'           => $userId,
                'name'              => $post_data['cus_name'],
                'email'             => $post_data['cus_email'],
                'phone'             => $post_data['cus_phone'],
                'amount'            => $post_data['total_amount'],
                'paid_amount'       => 0,
                'discount_amount'   => $post_data['discount_amount'],
                'addressLine1'      => $post_data['cus_add1'],
                'addressLine2'      => $post_data['cus_add2'],
                'country_id'        => $post_data['cus_country'],
                'division_id'       => $post_data['cus_state'],
                'district_id'       => $post_data['cus_district'],
                'zip_code'          => $post_data['cus_postcode'],
                'shipping_method'   => $post_data['shipping_method'],
                'cupon_code'        => $post_data['coupon_code'],
                'status'            => 'Pending',
                'transaction_id'    => $post_data['tran_id'],
                'currency'          => $post_data['currency'],
                'order_date'        => $order_date,
                'order_time'        => Carbon::now(),
                'created_at'        => $createdAt,
            ]);

            //get order id
            $transactionId = $post_data['tran_id'];
            $order_details = DB::table('orders')
                    ->where('transaction_id', $transactionId)->first();
            
            // update order id in cart
            foreach( Cart::totalItems() as $cart ){
                if( !is_null($cart->product->offer_price) ){
                   $products_price = $cart->product->offer_price;
                }else {
                    $products_price = $cart->product->regular_price;
                }

                $cart->prdtc_unt_pri = $products_price;
                $cart->order_id      = $order_details->id;
                $cart->save();

                // product quantity is minus
                $product = Product::where('id', $cart->product_id)->first();
                $up_qunt = $product->quantity - $cart->product_quantity;
                $product->update(['quantity' => $up_qunt ]);
            }

             // send mail
            $orderData = [
                'name'  => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
            ];

            $adminEmail    = "ahmedrahin660@gmail.com";
            $customerEmail = $post_data['cus_email'];
            Mail::to($adminEmail)->send( new newOrderEmail($orderData) );
            Mail::to($customerEmail)->send( new newOrderCustomerEmail($orderData) );

            #Check order status in order tabel against the transaction id or order id.
            $district = District::where('id', $order_details->district_id)->first();
            $division = State::where('id', $order_details->division_id)->first();
            $country  = Country::where('id', $order_details->country_id)->first();

            // expected_date set time
            Carbon::setLocale('en');
            $currentTime = Carbon::now();
            $currentTime->setTimezone('Asia/Dhaka');
            $createdAt = $currentTime->format('M-d-y h:i a');
            $expected_date = $currentTime->copy()->addDays(3)->format('M-d-y');

            // notification
            session()->flash('alert-type', 'success');
            session()->flash('message', 'Your Order has been Placed Successfully');
            return view('frontend.pages.order.cod-success-order', [
                'order_details' => $order_details,
                'district'      => $district, 
                'division'      => $division, 
                'country'       => $country, 
                'expected_date' => $expected_date
            ]);
        }
        
        else if( $post_data['paymentMethod'] == 2 ){
            $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'user_id'           => $userId,
                'name'              => $post_data['cus_name'],
                'email'             => $post_data['cus_email'],
                'phone'             => $post_data['cus_phone'],
                'amount'            => $post_data['total_amount'],
                'paid_amount'       => $post_data['paid_amount'],
                'discount_amount'   => $post_data['discount_amount'],
                'addressLine1'      => $post_data['cus_add1'],
                'addressLine2'      => $post_data['cus_add2'],
                'country_id'        => $post_data['cus_country'],
                'division_id'       => $post_data['cus_state'],
                'district_id'       => $post_data['cus_district'],
                'zip_code'          => $post_data['cus_postcode'],
                'shipping_method'   => $post_data['shipping_method'],
                'cupon_code'        => $post_data['coupon_code'],
                'status'            => 'Pending',
                'transaction_id'    => $post_data['tran_id'],
                'currency'          => $post_data['currency'],
                'order_date'        => $order_date,
                'order_time'        => Carbon::now(),
                'created_at'        => $createdAt,
            ]);

            //get order id
            $transactionId = $post_data['tran_id'];
            $order_details = DB::table('orders')
                ->where('transaction_id', $transactionId)->first();
            
            // update order id in cart
            foreach( Cart::totalItems() as $cart ){
                if( !is_null($cart->product->offer_price) ){
                   $products_price = $cart->product->offer_price;
                }else {
                    $products_price = $cart->product->regular_price;
                }

                $cart->prdtc_unt_pri = $products_price;
                $cart->order_id      = $order_details->id;
                $cart->save();

                // product quantity is minus
                $product = Product::where('id', $cart->product_id)->first();
                $up_qunt = $product->quantity - $cart->product_quantity;
                $product->update(['quantity' => $up_qunt ]);
            }

            $sslc = new SslCommerzNotification();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->makePayment($post_data, 'hosted');

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            }
        }
    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('total_amount');
        $currency = $request->input('currency');
        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)->first();

         // send mail
         $orderData = [
            'name'  => $order_details->name,
            'email' => $order_details->email,
            'phone' => $order_details->phone,
        ];

        $adminEmail    = "ahmedrahin660@gmail.com";
        $customerEmail = $orderData['email'];
        Mail::to($adminEmail)->send( new newOrderEmail($orderData) );
        Mail::to($customerEmail)->send( new newOrderCustomerEmail($orderData) );

        $district = District::where('id', $order_details->district_id)->first();
        $division = State::where('id', $order_details->division_id)->first();
        $country  = Country::where('id', $order_details->country_id)->first();

        // expected_date set time
        Carbon::setLocale('en');
        $currentTime = Carbon::now();
        $currentTime->setTimezone('Asia/Dhaka');
        $createdAt = $currentTime->format('M-d-y h:i a');
        $expected_date = $currentTime->copy()->addDays(3)->format('M-d-y');
        
        // notification
        session()->flash('alert-type', 'success');
        session()->flash('message', 'Your Order has been Placed Successfully');
        return view('frontend.pages.order.success-order', [
            'order_details' => $order_details,
            'district'      => $district, 
            'division'      => $division, 
            'country'       => $country, 
            'expected_date' => $expected_date
        ]);

    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}