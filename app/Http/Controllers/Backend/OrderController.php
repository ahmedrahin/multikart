<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Order;
use App\Models\State;
use App\Models\District;
use App\Models\Country;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use DB;
use DataTables;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a all order.
     */
    public function manage()
    {   
        if( request()->ajax() ){
            $this->sl = 0;
            $orderList = Order::orderBy('id', 'desc')->get();
            return Datatables::of($orderList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('customer_name',function($data){
                    return $data->user->name;
                })
                ->addColumn('phone',function($data){
                    return $data->phone;
                })
                ->addColumn('Total_Amount',function($data){
                    return "৳" . $data->amount;
                })
                ->addColumn('status',function($data){
                    if( $data->status == "Pending" ){
                        return '<div class="badge rounded-pill text-secondary bg-light-secondary p-2 text-uppercase px-3 pending"><i class="bx bxs-circle me-1"></i>Pending</div>';
                    }else if( $data->status == "Processing" ){
                        return '<div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Processing</div>';
                    }else if( $data->status == "Completed" ){
                        return '<div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Completed</div>';
                    }else if( $data->status == "Canceled" ){
                        return '<div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Canceled</div>';
                    }
                })
                ->addColumn('date',function($data){
                    return $data->order_date;
                })
                ->addColumn('action', function($data) {
                    return '<div class="btn-group">' .
                        '<button class="btn btn-primary">' .
                            '<a href="' . route('order-details', $data->id) . '">Order Details</a>' .
                        '</button>' .
                        '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#order' . $data->id . '">Drop</button>' .
                    '</div>';
                })
            
            ->rawColumns(['sl', 'customer_name', 'phone','Total_Amount', 'status', 'date', 'action'])
            ->make(true);
        }

        $orderList = Order::orderBy('id', 'desc')->get();
        return view('backend.pages.order.manage', compact('orderList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function order_details(string $id)
    {
        $edit = Order::find($id);
        if( !is_null( $edit ) ){
            $items = Cart::where('order_id', $edit->id)->get();
            $editData = Order::where('id', $edit->id)->first();
            // expected_date set time
            Carbon::setLocale('en');
            $orderTime = $editData->created_at;
            $orderTime->setTimezone('Asia/Dhaka');
            $createdAt = $orderTime->format('M-d-y h:i a');
            $expected_date = $orderTime->copy()->addDays(3)->format('M-d-y');

            return view('backend.pages.order.details', compact('editData', 'items', 'expected_date'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation
        $request->validate([
            'status' => 'required',
        ]);
        $update = Order::find($id);
        if( !empty( $update ) ){
            $update->status = $request->status;
            $update->save();

            // notification
            session::flash('alert-type', 'success');
            session::flash('message', 'Order Status is Changed');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Order::find($id);
        if( !empty( $delete ) ){
            $delete->delete();
            // notification
            session::flash('alert-type', 'error');
            session::flash('message', 'Order has been delete');
            return redirect()->back();
        }
    }
}
