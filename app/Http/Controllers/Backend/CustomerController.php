<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use DataTables;

class CustomerController extends Controller
{
    /**
     * All customer list
     */
    public function manage()
    {   
        if (request()->ajax()) {
            $this->sl = 0;
            $customers = User::orderBy('name', 'asc')->get();
            $orders = Order::get();
            $filteredCustomers = [];
        
            foreach ($customers as $customer) {
                $ordersForCustomer = $orders->where('user_id', $customer->id);
                $totalOrders = $ordersForCustomer->count();
        
                if ($totalOrders > 0) {
                    $filteredCustomers[] = $customer;
                }
            }
        
            return DataTables()->of($filteredCustomers)
                ->addIndexColumn()
                ->addColumn('sl', function ($row) {
                    return $this->sl = $this->sl + 1;
                })
                ->addColumn('customer_name', function ($data) {
                    return $data->name;
                })
                ->addColumn('email_address', function ($data) {
                    return $data->email;
                })
                ->addColumn('phone', function ($data) use ($orders) {
                    if( !is_null($data->phone) ){
                        return $data->phone;
                    }else{
                        $customerOrder = $orders->where('user_id', $data->id)->first();
                        if (!is_null($customerOrder) && !is_null($customerOrder->phone)) {
                            return $customerOrder->phone;
                        } else {
                            return "N/A";
                        }
                    }
                })
                ->addColumn('total_orders', function ($data) use ($orders) {
                    $ordersForCustomer = $orders->where('user_id', $data->id);
                    return $ordersForCustomer->count();
                })
                ->addColumn('pending_orders', function ($data) use ($orders) {
                    $ordersForCustomer = $orders->where('user_id', $data->id);
                    return $ordersForCustomer->where('status', 'Pending')->count();
                })
                ->addColumn('total_payment', function ($data) use ($orders) {
                    $ordersForCustomer = $orders->where('user_id', $data->id);
                    $canceledOrder = $ordersForCustomer->where('status', 'Canceled');
                    return $ordersForCustomer->sum('amount') - $canceledOrder->sum('amount');
                })
                ->rawColumns(['sl', 'customer_name', 'email_address', 'phone', 'total_orders', 'pending_orders', 'total_payment'])
                ->make(true);
        }
        

        $customers = User::with('order')->orderBy('name', 'asc')->get();
        $orders    = Order::get();
        return view('backend.pages.customer.manage', compact('customers', 'orders'));
    }

}
