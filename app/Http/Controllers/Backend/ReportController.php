<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use PDF;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show()
    {   
        $allProduct = Product::all();
       return view ('backend.pages.reports.selling-report', compact('allProduct'));
    }

    // filter by date
    public function filterByDate(Request $request){   
        $request->validate([
            'firstDate' => 'required|date_format:Y-m-d',
            'lastDate'  => 'required|date_format:Y-m-d|after_or_equal:firstDate',
        ]);

        $firstDate = $request->firstDate;
        $lastDate  = $request->lastDate;

        // convert to order date format
        $order_firstDate = date("M-d-y", strtotime($firstDate));
        $order_lastDate  = date("M-d-y", strtotime($lastDate));

        $orders = Order::whereBetween('order_date', [$order_firstDate, $order_lastDate])->where('status', 'Completed')->get();
        $totel_amn = $orders->sum('paid_amount');

        // get product qty
        if( $orders->count() > 0 ){
            foreach ($orders as $order) {
                $qty = Cart::where('order_id', $order->id)->sum('product_quantity');
                $order->quantity = $qty;
            }

            return response()->json([
                'orders'    => $orders,
                'date'      => $order_firstDate. " to " .$order_lastDate,
                'qty'       => $qty,
                'totel_amn' => $totel_amn
            ]);
        }

        return response()->json([
            'orders'    => $orders,
            'date'      => $order_firstDate. " to " .$order_lastDate,
            'totel_amn' => $totel_amn
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }

    // delete order
    public function deleteOrder(string $id){
        $delOrder = Order::findorFail($id);
        $delOrder->delete();
        
    }

    public function generatePdf(Request $request)
    {
        $pdf = PDF::loadView('pdf');
        $path = public_path('pdf/');
        $fileName = "details.pdf";
        $pdf->save
    }
}
