<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Auth;
use DataTables;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'review' => 'required',
            'rating' => 'required',
        ]);

        $review = new Review();
        $review->user_id    = Auth::user()->id;
        $review->product_id = $request->productId;
        $review->review     = $request->review;
        $review->rating     = $request->rating;

        session::flash('alert-type', 'success');
        session::flash('message', 'Thank You for submited your review');
        $review->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
