<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use Dompdf\Exception as DompdfException;
use Dompdf\Dompdf;
use Dompdf\Options;


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
        $totel_amn = $orders->sum('amount');

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

    // filter by product
    public function filterByProduct(Request $request){
        $productId = $request->product;
        $orders = Cart::where('order_id', '!=', null)->where('product_id', $productId)->get();
        foreach ($orders as $order) {
            
     
        }
    }

    // delete order
    public function deleteOrder(string $id){
        $delOrder = Order::findorFail($id);
        $delOrder->delete();
        
    }

    public function generatePdf(Request $request)
    {
        try {
            // Load the HTML content for the PDF (you may need to pass dynamic content here)
            $htmlContent = '<h1>Hello, World!</h1>'; // Replace with your actual HTML content

            // Create Dompdf instance
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $dompdf = new Dompdf($options);

            // Load HTML content into Dompdf
            $dompdf->loadHtml($htmlContent);

            // (Optional) Set paper size and orientation
            $dompdf->setPaper('A4', 'portrait');

            // Render the PDF
            $dompdf->render();

            // Output the PDF
            return $dompdf->stream('Details.pdf');
        } catch (DompdfException $e) {
            // Log any errors that occur during PDF generation
            \Log::error('Dompdf error: '.$e->getMessage());
            return response()->json(['error' => 'Error generating PDF. Please try again.'], 500);
        }
    }
}
