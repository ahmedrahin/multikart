<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Review;
use App\Models\ProductVariation;
use App\Models\ProductAttribute;
use App\Models\VariationValue;
use Illuminate\Support\Facades\Auth;

class ProductpagesController extends Controller
{
    /**
     * Display a listing of the product.
     */
    public function all_products(Request $request)
    {
        $perPage = $request->input('perPage', 20);
        $sort_items = $request->input('sortItems');
        $q_brands = $request->query("brands");
        $p_range  = $request->query("prange");
        
        $query = Product::where('status', 1);

        // Filter products by brand IDs if brands are selected
        if (!empty($q_brands)) {
            $brandIds = explode(',', $q_brands);
            $query->whereIn('brand_id', $brandIds);
        }

        // Apply sorting based on user selection
        if ($sort_items == "lowToHigh") {
            $query->orderByRaw('COALESCE(offer_price, regular_price) ASC');
        } elseif ($sort_items == "highToLow") {
            $query->orderByRaw('COALESCE(offer_price, regular_price) DESC');
        } else {
            // Default sorting by ID in descending order
            $query->orderBy('id', 'desc');
        }

        // Paginate the results
        $products = $query->paginate($perPage);

        // Retrieve variations and options
        $variations = ProductVariation::orderBy('var_name', 'asc')->get();
        $options = VariationValue::orderBy('option', 'asc')->get();

        return view('frontend.pages.product.all-products', compact('products', 'variations', 'options', 'q_brands'));
    }

    /**
     * Display a listing of the category wise prodcut.
     */
    public function category_products(Request $request, string $slug)
    {       
        $category    = Category::where('slug', $slug)->first();
        $subCategory = Subcategory::where('slug', $slug)->first();
        $q_brands = ''; // Initialize $q_brands variable to an empty string

        if (!empty($category->id)) {
            $perPage    = $request->input('perPage', 20); 
            $sort_items = $request->input('sortItems'); 
            $q_brands   = $request->query("brands"); // Retrieve selected brands

            $query = Product::where('status', 1)->where('category_id', $category->id);

            // Filter products by brand IDs if brands are selected
            if (!empty($q_brands)) {
                $brandIds = explode(',', $q_brands);
                $query->whereIn('brand_id', $brandIds);
            }

            // Apply sorting based on user selection
            if ($sort_items == "lowToHigh") {
                $query->orderByRaw('COALESCE(offer_price, regular_price) ASC');
            } elseif ($sort_items == "highToLow") {
                $query->orderByRaw('COALESCE(offer_price, regular_price) DESC');
            } else {
                // Apply default sorting (by ID in descending order)
                $query->orderBy('id', 'desc');
            }

            // Paginate the results
            $products = $query->paginate($perPage);

            return view('frontend.pages.product.category', compact('products', 'category', 'q_brands'));
        } elseif (!empty($subCategory->id)) {
            $subCategoryList = Subcategory::where('slug', $slug)->first();
            $perPage         = $request->input('perPage', 20); 
            $sort_items      = $request->input('sortItems'); 
            $q_brands        = $request->query("brands"); // Retrieve selected brands

            $query = Product::where('status', 1)->where('subCategory_id', $subCategoryList->id);

            // Filter products by brand IDs if brands are selected
            if (!empty($q_brands)) {
                $brandIds = explode(',', $q_brands);
                $query->whereIn('brand_id', $brandIds);
            }

            // Apply sorting based on user selection
            if ($sort_items == "lowToHigh") {
                $query->orderByRaw('COALESCE(offer_price, regular_price) ASC');
            } elseif ($sort_items == "highToLow") {
                $query->orderByRaw('COALESCE(offer_price, regular_price) DESC');
            } else {
                // Apply default sorting (by ID in descending order)
                $query->orderBy('id', 'desc');
            }

            // Paginate the results
            $products = $query->paginate($perPage);

            return view('frontend.pages.product.category', compact('products', 'subCategory', 'q_brands'));
        }
    }

    /**
     * Display a listing of the offer product.
     */
    public function offer_products(Request $request)
    {
        $perPage = $request->input('perPage', 20);
        $sort_items = $request->input('sortItems');
        $q_brands = $request->query("brands");
        $p_range  = $request->query("prange");
        
        $query = Product::where('status', 1)->whereNotNull('offer_price');

        // Filter products by brand IDs if brands are selected
        if (!empty($q_brands)) {
            $brandIds = explode(',', $q_brands);
            $query->whereIn('brand_id', $brandIds);
        }

        // Apply sorting based on user selection
        if ($sort_items == "lowToHigh") {
            $query->orderByRaw('COALESCE(offer_price, regular_price) ASC');
        } elseif ($sort_items == "highToLow") {
            $query->orderByRaw('COALESCE(offer_price, regular_price) DESC');
        } else {
            // Default sorting by ID in descending order
            $query->orderBy('id', 'desc');
        }

        // Paginate the results
        $products = $query->paginate($perPage);

        // Retrieve variations and options
        $variations = ProductVariation::orderBy('var_name', 'asc')->get();
        $options = VariationValue::orderBy('option', 'asc')->get();

        return view('frontend.pages.product.offer-products', compact('products', 'variations', 'options', 'q_brands'));
    }

    /**
     * Display a listing of the single product.
     */
    public function single_products(string $slug)
    {
        $product_detail = Product::where('slug', $slug)->first();
        $user = Auth::user();
        if ($user) {
            // User is logged in
            $wishlist_detail = Wishlist::where('product_id', $product_detail->id)
                ->where('user_id', $user->id)
                ->first();
        } else {
            // User is not logged in, use IP address
            $ip_address = request()->ip(); // Get the user's IP address
            $wishlist_detail = Wishlist::where('product_id', $product_detail->id)
                ->where('ip_address', $ip_address)
                ->first();
        }   

        $varitaions    = ProductVariation::orderBy('var_name', 'asc')->get();
        $options       = VariationValue::orderBy('option', 'asc')->get();     
        return view('frontend.pages.product.product-details', compact('product_detail', 'wishlist_detail', 'varitaions', 'options'));
    }

    // search box 
    public function search_product(Request $request){
        $perPage = $request->input('perPage', 20); 
        $sortItems = $request->input('sortItems'); 
        $searchTerm = $request->input('term');
        $q_brands = $request->query("brands");
    
        $query = Product::where('title', 'like', "%$searchTerm%")
                    ->orWhere('tags', 'like', "%$searchTerm%")
                    ->where('status', 1);
    
        // Filter products by brand IDs if brands are selected
        if (!empty($q_brands)) {
            $brandIds = explode(',', $q_brands);
            $query->whereIn('brand_id', $brandIds);
        }
    
        // Apply sorting based on user selection
        if ($sortItems == "lowToHigh") {
            $query->orderByRaw('COALESCE(offer_price, regular_price)');
        } elseif ($sortItems == "highToLow") {
            $query->orderByRaw('COALESCE(offer_price, regular_price) DESC');
        } elseif ($sortItems == "menu_order") {
            // No specific ordering needed
        } else {
            // Apply default sorting (by ID in descending order)
            $query->orderBy('id', 'desc');
        }
    
        // Paginate the results
        $products = $query->paginate($perPage);
    
        return view('frontend.pages.product.search', compact('products', 'searchTerm', 'q_brands'));
    }
    
    // ajax search box 
    public function ajaxsearchProduct(){
        $products = Product::where('status', 1)->get();
        return response()->json($products);
    }


}
