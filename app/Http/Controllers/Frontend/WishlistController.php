<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use Illuminate\Support\Facades\Session;
use Auth;
use DataTables;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        if( Auth::check() ){
            $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();
         }else{
            $wishlists = Wishlist::where('ip_address', request()->ip())->get();
         }
        return view('frontend.pages.customer-pages.wishlist', compact('wishlists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // check user has been log in or not
         if( Auth::check() ){
            $wishlist = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $request->productId)->first();
         }else{
            $wishlist = Wishlist::where('ip_address', request()->ip())->where('product_id', $request->productId)->first();
         }

         if( is_null($wishlist) ){
            $wishlist = new Wishlist();
            if( Auth::check() ){
                $wishlist->user_id = Auth::user()->id;
            }
            $wishlist->ip_address        = request()->ip();
            $wishlist->product_id        = $request->productId;

            // product save into the wishlist
            $wishlist->save();
            return response()->json([
                'html' => view('frontend.includes.wishlistItem')->render(),
                'msg' => 'The Item Added in your Wishlist',
            ]);
         }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cart = new Cart();
        if( Auth::check() ){
            $cart->user_id = Auth::id();
        }
        $cart->ip_address        = request()->ip();
        $cart->product_id        = $request->productId;
        $cart->product_quantity  = $request->quantity;

        // remove from wishlist
        $move_cart = Wishlist::find($id);
        
            if( !is_null(( $move_cart )) ){
                $move_cart->delete();

                $cart->save();
                return response()->json([
                    'html' => view('frontend.includes.wishlistItem')->render(),
                    'delWc' => view('frontend.includes.wishlistDetails')->render(),
                    'addCart' => view('frontend.includes.cartItem')->render(),
                    'yourWc' => view('frontend.pages.customer-pages.yourWishlist')->render(),
                    'msg' => 'The Item Added Into Cart',
                    'msgs' => 'The Item Remove From Wishlist',
                ]);
            }
    
    }

    // Wishlist list
    public function wishlistList()
    {
        if (request()->ajax()) {
            $this->sl = 0;
            $wishlists = Wishlist::orderBy('id', 'desc')->get();
            $filteredWishlist = [];
            $productIds = [];

            foreach ($wishlists as $wishlist) {
                $productId = $wishlist->product_id;
                if (!in_array($productId, $productIds)) {
                    $productIds[] = $productId;
                    $filteredWishlist[] = $wishlist->product;
                }
            }

            return Datatables::of($filteredWishlist)
                ->addIndexColumn()
                ->addColumn('sl', function ($row) {
                    return $this->sl = $this->sl + 1;
                })
                ->addColumn('image', function ($data) {
                    if (!is_null($data->thumb_image)) {
                        $imagePath = asset("uploads/product/thumb_image/" . $data->thumb_image);
                    } else {
                        $imagePath = asset("uploads/product/thumb_image/nothumb.jpg");
                    }
                    return '<img src="' . $imagePath . '" class="thumb" alt="Thumbnail"></img>';
                })
                ->addColumn('product_title', function ($data) {
                    return $data->title;
                })
                ->addColumn('quantity', function ($data) {
                    return $data->quantity;
                })
                ->addColumn('status', function ($data) {
                    if( $data->status == 1 ){
                        return '<div class="badge bg-success">Active</div>';
                    }else {
                        return '<div class="badge bg-danger">Inactive</div>';
                    }
                })
                ->addColumn('total', function ($data) {
                    $total = Wishlist::where('product_id', $data->id)->count();
                    return $total;
                })
                ->addColumn('details', function ($data) {
                    return '<a class="btn btn-primary br-0" href="' . route('product-detail', $data->id) . '" target="_blank">
                                <i class="bi bi-eye"></i>
                            </a>';
                })
                ->rawColumns(['sl', 'image', 'product_title', 'quantity', 'status', 'total', 'details'])
                ->make(true);
        }

        return view('backend.pages.wishlist.wishlist');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $del_wishlist = Wishlist::findorFail($id);
        $del_wishlist->delete();
        return response()->json([
            'html' => view('frontend.includes.wishlistItem')->render(),
            'delWc' => view('frontend.includes.wishlistDetails')->render(),
            'msg' => 'The Item Remove From Wishlist',
        ]);
    }
}
