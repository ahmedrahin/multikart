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
        $review->save();

        // product id
        $product_detail = Product::find($review->product_id);
        // review
        $reviews = Review::orderBy('id', 'desc')->where('product_id', $review->product_id)->get();
        return response()->json([
            'html' => view('frontend.includes.review', compact('product_detail', 'reviews'))->render(),
            'msg' => 'Thank You for submited your review',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Review::find($id);
        if( !is_null($delete) ){
            $delete->delete();

            // product id
            $product_detail = Product::find($delete->product_id);
            // review
            $reviews = Review::orderBy('id', 'desc')->where('product_id', $delete->product_id)->get();
            return response()->json([
                'html' => view('frontend.includes.review', compact('product_detail', 'reviews'))->render(),
                'msg' => 'Your review is deleted',
            ]);
        }
    }
}
