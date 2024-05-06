<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

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

        $orders = Order::whereBetween('order_date', [$order_firstDate, $order_lastDate])->get();

         return view('backend.pages.reports.selling-report', compact('firstDate', 'orders'));
        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
