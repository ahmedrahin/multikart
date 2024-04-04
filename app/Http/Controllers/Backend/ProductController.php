<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ImageGallery;
use App\Models\Wishlist;
use App\Models\ProductVariation;
use App\Models\ProductAttribute;
use App\Models\Review;
use App\Models\VariationValue;
use Illuminate\support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use DB;
use File;
use Image;
use DataTables;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $productList = Product::orderBy('title', 'asc')->whereIn('status', [1, 2])->get();
            return Datatables::of($productList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('thumb_image', function ($data) {
                    if (!is_null($data->thumb_image)) {
                        $imagePath = asset("uploads/product/thumb_image/" . $data->thumb_image);
                    } else {
                        $imagePath = asset("uploads/product/thumb_image/nothumb.jpg");
                    }
                    return '<img src="' . $imagePath . '" class="thumb" alt="Thumbnail"></img>';
                })                
                ->addColumn('product_title',function($data){
                    return $data->title;
                })
                ->addColumn('sku_code',function($data){
                    if( !is_null( $data->sku_code ) )
                       return $data->sku_code;
                    else{
                        return '<span class="no">N/A</span>';
                    }
                })
                ->addColumn('price',function($data){
                    if( !is_null($data->offer_price) ){
                        return $data->offer_price;
                    }else {
                        return $data->regular_price;
                    }
                })
                
                ->addColumn('category_name',function($data){
                    if(isset($data->category->id))
                        if( $data->category->status == 1 ){
                           return  $data->category->name;
                        }
                        else{
                            return '<span class="error">Uncategorize</span>';
                        } 
                    else{
                        return '<span class="error">Uncategorize</span>';
                    }
                })

                ->addColumn('status',function($data){
                    if( $data->status == 1 ){
                        return '<div class="badge bg-success">Active</div>';
                    }
                    else if( $data->status == 2 ){
                        return '<div class="badge bg-danger">Inactive</div>';
                    }
                })
                ->addColumn('action', function($data) {
                    return '<a class="btn btn-warning br-0" target="_blank" href="' . route('product-detail', $data->id) . '">
                                <i class="bi bi-eye"></i>
                            </a>' .
                            '<a class="btn btn-primary br-0" href="' . route('edit-product', $data->id) . '">
                                <i class="bi bi-pencil-fill"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#product' . $data->id . '"><span class="cancell">&#10060</span></button>' ;
                })
                
                ->rawColumns(['sl', 'thumb_image', 'product_title', 'sku_code','price', 'category_name', 'status', 'action'])
                ->make(true);
            }

        $productList = Product::orderBy('title', 'asc')->whereIn('status', [1, 2])->get();
        return view('backend.pages.product.manage', compact('productList'));
    }

    // reveiw
    public function Reviewmanage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $reviewList = Review::orderBy('id', 'desc')->get();
            return Datatables::of($reviewList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })                
                ->addColumn('product_title',function($data){
                    return $data->product->title;
                })
               
                ->addColumn('email',function($data){
                    return $data->user->email;
                })

                ->addColumn('message',function($data){
                    $review = $data->review;
                    // Limit the length of the review to 45 characters
                    if (strlen($review) > 85) {
                        $review = substr($review, 0, 85) . '...';
                    }
                    // Capitalize the first letter of the review
                    $review = ucfirst($review);
                    return '<p class="msg-info">' . $review . '</p>';
                })

                ->addColumn('rating', function($data) {
                     return $data->rating;;
                })
                
                ->addColumn('action', function($data) {
                    return '<a class="btn btn-primary br-0" target="_blank" href="' . route('product-detail', $data->product->id) . '">
                                <i class="bi bi-eye"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#product' . $data->product->id . '"><span class="cancell">&#10060</span></button>' ;
                })
                
                ->rawColumns(['sl', 'product_title', 'email', 'message', 'action'])
                ->make(true);
            }

        $reviewList = Review::orderBy('id', 'desc')->get();
        return view('backend.pages.product.reviews', compact('reviewList'));
    }

    /**
     * all featured product
     */
    public function featured_product()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $featuredList = Product::orderBy('title', 'asc')->where('is_featured', 1)->get();
            return Datatables::of($featuredList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('thumb_image', function ($data) {
                    if (!is_null($data->thumb_image)) {
                        $imagePath = asset("uploads/product/thumb_image/" . $data->thumb_image);
                    } else {
                        $imagePath = asset("uploads/product/thumb_image/nothumb.jpg");
                    }
                    return '<img src="' . $imagePath . '" class="thumb" alt="Thumbnail"></img>';
                })                
                ->addColumn('product_title',function($data){
                    return $data->title;
                })
                ->addColumn('sku_code',function($data){
                    if( !is_null( $data->sku_code ) )
                       return $data->sku_code;
                    else{
                        return '<span class="no">N/A</span>';
                    }
                })
                ->addColumn('price',function($data){
                    if( !is_null($data->offer_price) ){
                        return $data->offer_price;
                    }else {
                        return $data->regular_price;
                    }
                })
                
                ->addColumn('category_name',function($data){
                    if(isset($data->category->id))
                        if( $data->category->status == 1 ){
                           return  $data->category->name;
                        }
                        else{
                            return '<span class="error">Uncategorize</span>';
                        } 
                    else{
                        return '<span class="error">Uncategorize</span>';
                    }
                })

                ->addColumn('details',function($data){
                    return '<a class="btn btn-primary br-0" target="_blank" href="' . route('product-detail', $data->id) . '">
                                <i class="bi bi-eye"></i>
                            </a>';
                })
                ->addColumn('is_featured', function($data) {
                    return '<select class="featured" data-id="'.$data->id.'" data-url="'.route("update-feature-status", $data->id).'">' .
                                '<option value="1"' . ($data->is_featured == 1 ? " selected" : "") . '>Yes</option>' .
                                '<option value="0"' . ($data->is_featured == 0 ? " selected" : "") . '>No</option>' .
                            '</select>';
                })
                
                ->rawColumns(['sl', 'thumb_image', 'product_title', 'sku_code','price', 'category_name', 'details', 'is_featured'])
                ->make(true);
            }

        $featuredList = Product::orderBy('title', 'asc')->where('is_featured', 1)->get();
        return view('backend.pages.product.featured', compact('featuredList'));
    }

    // update feature prodcut
    public function update_feature(Request $request, $id)
    {
        // Retrieve the product by its ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->is_featured = $request->input('is_featured');
        $product->save();

        // Return a success response
        return response()->json(['message' => 'Feature status updated successfully'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $brandList = DB::table('brands')
                    ->where('status', 1)
                    ->orderBy('name', 'asc')
                    ->get();
        $categories    = Category::orderBy('name', 'asc')->where('status', 1)->get();
        $subCategories = Subcategory::orderBy('name', 'asc')->where('status', 1)->get();
        $varitaions    = ProductVariation::orderBy('var_name', 'asc')->get();
        $options       = VariationValue::orderBy('option', 'asc')->get();
        return view('backend.pages.product.create', compact('brandList', 'categories', 'subCategories', 'varitaions', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();

        $this->validate($request, [
            'title'                 => 'required|unique:products,title',
            'regular_price'         => 'required|numeric',
            'offer_price'           => 'nullable|numeric|lt:regular_price',
            'quantity'              => 'required|numeric',
            'short_description'     => 'max:200',
            'thumb_image'           => 'mimes:jpeg,png,jpg,gif',
            'back_image'            => 'mimes:jpeg,png,jpg,gif',
            'images[]'              => 'mimes:jpeg,png,jpg,gif',
        ],[
            'subCategory_id.required'   => "Please Select a Sub-category",
            'short_description.max'     => "The description must not be greater than 200 characters", 
            'offer_price.lt'            => 'The offer price must be lower than the regular price.',  
        ]);

        $product->title           = $request->title;
        $product->slug            = Str::slug($request->title);
        $product->brand_id        = $request->brand_id;
        $product->category_id     = $request->category_id;
        $product->subCategory_id  = $request->subCategory_id;
        $product->regular_price   = $request->regular_price;
        $product->offer_price     = $request->offer_price;
        $product->short_details   = $request->short_description;
        $product->long_details    = $request->long_description;
        $product->quantity        = $request->quantity;
        $product->sku_code        = $request->sku_code;
        $product->is_featured     = $request->is_featured;
        $product->video_link      = $request->video_link;
        $product->status          = $request->status;
        $product->tags            = $request->tags;

        // thumbnail image upload
        if( $request->thumb_image ){
            // get image from user
            $thumb_image = $request->file('thumb_image');
            // change image name
            $thumb = time() . '-product.' . $thumb_image->getClientOriginalExtension();
            // set location
            $thumbLocation = public_path('uploads/product/thumb_image/' . $thumb);

            // create image to the folder
            Image::make($thumb_image)->resize(736, 1000)->save($thumbLocation);
            // save the image name into the db
            $product->thumb_image = $thumb;
        }

        // back image upload
        if( $request->back_image ){
            // get image from user
            $back_image = $request->file('back_image');
            // change image name
            $backImg = time() . '-product.' . $back_image->getClientOriginalExtension();
            // set location
            $backImgLocation = public_path('uploads/product/back_image/' . $backImg);

            // create image to the folder
            Image::make($back_image)->resize(736, 1000)->save($backImgLocation);
            // save the image name into the db
            $product->back_image = $backImg;
        }

        // save product
        $product->save();

        // images upload
        $imageData = [];
        if ($request->images) {
            $files = $request->file('images');
            
            foreach ($files as $file) {
                $imgName = rand() . '-product-gallery.' . $file->getClientOriginalExtension();
                $imgsLocation = "uploads/product/image-gallery/";
                
                // Move the original file
                $file->move($imgsLocation, $imgName);
                // Resize the image using Intervention Image
                $img = Image::make($imgsLocation . $imgName);
                $img->resize(736, 1000);
                $img->save($imgsLocation . $imgName);
            
                $imageData[] = [
                    'product_id' => $product->id,
                    'name' => $imgsLocation . $imgName
                ];
            }
        }
        // save product gallery image
       ImageGallery::insert($imageData);

        // save attribute
        if ($request->has('varition') && is_array($request->varition)) {
            foreach ($request->varition as $index => $variationId) {
                if (!empty($variationId) && !empty($request->option[$index])) {
                    $productAttribute = new ProductAttribute();
                    $productAttribute->variation_id = $variationId;
                    $productAttribute->value_id = $request->option[$index];
                    $productAttribute->products_id = $product->id;
        
                    if (isset($request->regular_priceV[$index]) && !empty($request->regular_priceV[$index])) {
                        $productAttribute->regular_price = $request->regular_priceV[$index];
                    }
        
                    if (isset($request->offer_priceV[$index]) && !empty($request->offer_priceV[$index])) {
                        $productAttribute->offer_price = $request->offer_priceV[$index];
                    }
        
                    if (isset($request->quantityV[$index]) && !empty($request->quantityV[$index])) {
                        $productAttribute->quantity = $request->quantityV[$index];
                    }
        
                    if (isset($request->sku_codeV[$index]) && !empty($request->sku_codeV[$index])) {
                        $productAttribute->sku_code = $request->sku_codeV[$index];
                    }
        
                     // Handle file upload for thumbnail image if needed
                     if ($request->hasFile('var_image')) {
                        foreach ($request->file('var_image') as $index => $file) {
                            if ($file->isValid()) {
                                $imageName = rand() . '-product-' . $index . '.' . $file->getClientOriginalExtension();
                                $imagePath = 'uploads/product/attr_image/';
                                $file->storeAs($imagePath, $imageName);
                
                                // You might need to adjust this part to match your database structure
                                $productAttribute->thumb_image = $imagePath . $imageName;
                            }
                        }
                    }
                    
                    
                    $productAttribute->save();
                }
            }
        }
        
       $notification = array(
            'message'    => 'Product Added Successfully',
            'alert-type' => 'success'
       );
       return redirect()->route('manage-product')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Product::find($id);
        if(!is_null($edit)){
            $editData  = Product::where('id', $edit->id)->first();
            $brandList = DB::table('brands')
                        ->where('status', 1)
                        ->orderBy('name', 'asc')
                        ->get();
            $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();
            $subCategories = Subcategory::orderBy('name', 'asc')->where('status', 1)->get();
            $productImages = ImageGallery::where('product_id', $edit->id)->get();
            $varitaions    = ProductVariation::orderBy('var_name', 'asc')->get();
            $options       = VariationValue::orderBy('option', 'asc')->get();
            $product_attrs  = ProductAttribute::where('products_id', $edit->id)->get();
            return view('backend.pages.product.edit', compact('editData','brandList', 'categories', 'subCategories', 'productImages', 'varitaions', 'options', 'product_attrs'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = Product::find($id);

        if( !is_null($update) ){

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('products')->ignore($update->id)
                ],
                'regular_price'         => 'required|numeric',
                'offer_price'           => 'nullable|numeric|lt:regular_price',
                'quantity'              => 'required|numeric',
                'short_description'     => 'max:200',
            ],[
                'subCategory_id.required'   => "Please Select a Sub-category",
                'short_description.max'     => "The description must not be greater than 200 characters", 
                'offer_price.lt'            => 'The offer price must be lower than the regular price.',  
            ]);

            $update->title           = $request->title;
            $update->slug            = Str::slug($request->title);
            $update->brand_id        = $request->brand_id;
            $update->category_id     = $request->category_id;
            $update->subCategory_id  = $request->subCategory_id;
            $update->regular_price   = $request->regular_price;
            $update->offer_price     = $request->offer_price;
            $update->short_details   = $request->short_description;
            $update->long_details    = $request->long_description;
            $update->quantity        = $request->quantity;
            $update->sku_code        = $request->sku_code;
            $update->is_featured     = $request->is_featured;
            $update->video_link      = $request->video_link;
            $update->status          = $request->status;
            $update->tags            = $request->tags;

            if( $request->status != 1 ){
                // delete cart item
                $cart_item = Cart::where('product_id', $update->id)->get();
                foreach( $cart_item as $cart ){
                    $cart->delete();
                }
            }

            // if( $request->status == 0 ){
            //     // delete wishlist item
            //     $wishlist_item = Wishlist::where('product_id', $update->id)->get();
            //     foreach( $wishlist_item as $wishlist ){
            //         $wishlist->delete();
            //     }
            // }

            // Thumbnail image upload
            if ($request->hasRemove) {
                // Check and delete old image
                if (File::exists('uploads/product/thumb_image/' . $update->thumb_image)) {
                    File::delete('uploads/product/thumb_image/' . $update->thumb_image);
                }
                $update->thumb_image = null;
            } else if ($request->hasFile('thumb_image')) {
                // Check and delete old image
                if (File::exists('uploads/product/thumb_image/' . $update->thumb_image)) {
                    File::delete('uploads/product/thumb_image/' . $update->thumb_image);
                }
            
                // Get image from user
                $thumb_image = $request->file('thumb_image');
                // Change image name
                $thumb = time() . '-product.' . $thumb_image->getClientOriginalExtension();
                // Set location
                $thumbLocation = public_path('uploads/product/thumb_image/' . $thumb);
            
                // Create and save the new thumbnail image
                Image::make($thumb_image)->resize(736, 1000)->save($thumbLocation);
                // Save the new image name into the database
                $update->thumb_image = $thumb;
            }

            // back image upload
            if ($request->hasbackRemove) {
                // Check and delete old image
                if (File::exists('uploads/product/back_image/' . $update->back_image)) {
                    File::delete('uploads/product/back_image/' . $update->back_image);
                }
                $update->back_image = null;
            } else if ($request->hasFile('back_image')) {
                // Check and delete old image
                if (File::exists('uploads/product/back_image/' . $update->back_image)) {
                    File::delete('uploads/product/back_image/' . $update->back_image);
                }
            
                // get image from user
                $back_image = $request->file('back_image');
                // change image name
                $backImg = time() . '-product.' . $back_image->getClientOriginalExtension();
                // set location
                $backImgLocation = public_path('uploads/product/back_image/' . $backImg);

                // create image to the folder
                Image::make($back_image)->resize(736, 1000)->save($backImgLocation);
                // save the image name into the db
                $update->back_image = $backImg;
            }

            // update product information
            $update->save();

             // images update
             if ($request->images) {
                // Retrieve existing gallery images
                $galleryImages = ImageGallery::where('product_id', $update->id)->get();

                // Delete existing images from the folder
                foreach ($galleryImages as $galleryImage) {
                    $filePath = public_path($galleryImage->name);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }

                $newImageCount = count($request->file('images'));
                if ($newImageCount <= $galleryImages->count()) {
                    foreach ($galleryImages as $key => $galleryImage) {
                        if ($key < $newImageCount) {
                            // Update existing record with the new image
                            $file = $request->file('images')[$key];
                            $imgName = rand() . '-product-gallery.' . $file->getClientOriginalExtension();
                            $imgsLocation = "uploads/product/image-gallery/";
            
                            // Move the original file
                            $file->move($imgsLocation, $imgName);
            
                            // Resize the image using Intervention Image
                            $img = Image::make($imgsLocation . $imgName);
                            $img->resize(736, 1000);
                            $img->save($imgsLocation . $imgName);
            
                            $galleryImage->update(['name' => $imgsLocation . $imgName]);
                        } else {
                            // Delete excess records
                            $galleryImage->delete();
                        }
                    }
                } else {
                    // Update existing records with the new image names
                    foreach ($galleryImages as $key => $galleryImage) {
                        $file = $request->file('images')[$key];
                        $imgName = rand() . '-product-gallery.' . $file->getClientOriginalExtension();
                        $imgsLocation = "uploads/product/image-gallery/";
            
                        // Move the original file
                        $file->move($imgsLocation, $imgName);

                        $img = Image::make($imgsLocation . $imgName);
                        $img->resize(736, 1000);
                        $img->save($imgsLocation . $imgName);
            
                        $galleryImage->update(['name' => $imgsLocation . $imgName]);
                    }
            
                    // Upload new images and create new records for them
                    $additionalImages = array_slice($request->file('images'), $galleryImages->count());
                    foreach ($additionalImages as $file) {
                        $imgName = rand() . '-product-gallery.' . $file->getClientOriginalExtension();
                        $imgsLocation = "uploads/product/image-gallery/";
            
                        // Move the original file
                        $file->move($imgsLocation, $imgName);
            
                        // Resize the image using Intervention Image
                        $img = Image::make($imgsLocation . $imgName);
                        $img->resize(736, 1000);
                        $img->save($imgsLocation . $imgName);
            
                        // Create new record for the additional image
                        ImageGallery::create([
                            'product_id' => $update->id,
                            'name' => $imgsLocation . $imgName
                        ]);
                    }
                }
            }
            
             // product attribute delete
             ProductAttribute::where('products_id', $update->id)->delete();
            // Update attributes
            if ($request->has('varition') && is_array($request->varition)) {
                foreach ($request->varition as $index => $variationId) {
                    if (!empty($variationId) && !empty($request->option[$index])) {
                        $productAttribute = new ProductAttribute();
                        $productAttribute->variation_id = $variationId;
                        $productAttribute->value_id = $request->option[$index];
                        $productAttribute->products_id = $update->id;
            
                        if (isset($request->regular_priceV[$index]) && !empty($request->regular_priceV[$index])) {
                            $productAttribute->regular_price = $request->regular_priceV[$index];
                        }
            
                        if (isset($request->offer_priceV[$index]) && !empty($request->offer_priceV[$index])) {
                            $productAttribute->offer_price = $request->offer_priceV[$index];
                        }
            
                        if (isset($request->quantityV[$index]) && !empty($request->quantityV[$index])) {
                            $productAttribute->quantity = $request->quantityV[$index];
                        }
            
                        if (isset($request->sku_codeV[$index]) && !empty($request->sku_codeV[$index])) {
                            $productAttribute->sku_code = $request->sku_codeV[$index];
                        }
            
                        // Handle file upload for thumbnail image if needed
                        if ($request->hasFile('var_image') && $request->file('var_image')[$index]->isValid()) {
                            $imageName = rand() . '-product-' . $index . '.' . $request->file('var_image')[$index]->getClientOriginalExtension();
                            $imagePath = 'uploads/product/attr_image/';
                            $request->file('var_image')[$index]->storeAs($imagePath, $imageName);
                            $productAttribute->thumb_image = $imageName;
                        }
                        
                        $productAttribute->save();
                    }
                }
            }
            
            $notification = array(
                'message'    => 'Product Information Updated',
                'alert-type' => 'info'
            );

            return redirect()->route('manage-product')->with($notification);
        }
    }

    public function trash_manage(){
        if( request()->ajax() ){
            $this->sl = 0;
            $productList = Product::orderBy('title', 'asc')->where('status', 0)->get();
            return Datatables::of($productList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('thumb_image', function ($trash) {
                    if (!is_null($trash->thumb_image)) {
                        $imagePath = asset("uploads/product/thumb_image/" . $trash->thumb_image);
                    } else {
                        $imagePath = asset("uploads/product/thumb_image/nothumb.jpg");
                    }
                    return '<img src="' . $imagePath . '" class="thumb" alt="Thumbnail"></img>';
                })  
                ->addColumn('product_title',function($trash){
                    return $trash->title;
                })
                ->addColumn('sku_code',function($trash){
                    if( !is_null( $trash->sku_code ) )
                       return $trash->sku_code;
                    else{
                        return '<span class="no">N/A</span>';
                    }
                })
                ->addColumn('price',function($trash){
                    if( !is_null($trash->offer_price) ){
                        return $trash->offer_price;
                    }else {
                        return $trash->regular_price;
                    }
                })
                
                ->addColumn('category_name',function($trash){
                    if(isset($trash->category->id))
                        if( $trash->category->status == 1 ){
                           return  $trash->category->name;
                        }
                        else{
                            return '<span class="error">Uncategorize</span>';
                        } 
                    else{
                        return '<span class="error">Uncategorize</span>';
                    }
                })
                ->addColumn('action', function($trash) {
                    $actionButtons = '<div class="btn-group">
                        <form action="' . route('restore-product', $trash->id) . '" class="btn btn-primary" method="POST">' .
                            csrf_field() .
                            '<button type="submit">Restore</button>' .
                        '</form>' .
                        '<form action="' . route('destroy-product', $trash->id) . '" method="POST" class="btn btn-danger">' .
                            csrf_field() .
                            '<button type="submit">Permanent Delete</button>' .
                        '</form>' .
                    '</div>';
                    
                    return  $actionButtons;
                })
                
                ->rawColumns(['sl','thumb_image', 'product_title', 'sku_code','price', 'category_name', 'action'])
                ->make(true);
            }

        $trashList = Product::orderBy('title', 'asc')->where('status', 0)->get();
        return view('backend.pages.product.trash', compact('trashList'));
    }

    public function trash(string $id){
        $trash = Product::find($id);
        if( !is_null($trash) ){
            $trash->status = 0;
            $notification = array(
                'message'    => 'The Product is Deleted',
                'alert-type' => 'warning'
            );
            // delete cart item
            $cart_item = Cart::where('product_id', $trash->id)->get();
            foreach( $cart_item as $cart ){
                $cart->delete();
            }
            $trash->save();
            return redirect()->back()->with($notification);
        }
    }

    public function restore(string $id){
        $restore = Product::find($id);
        if(!is_null($restore)){
            $restore->status = 1;
            $notification = array(
                'message'    => 'The Product is Restore',
                'alert-type' => 'info'
            );
            $restore->save();
            return redirect()->back()->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Product::find($id);
        if(!is_null($delete)){
            //remove product image
            $gallery_image = ImageGallery::where('product_id', $delete->id)->get();
            foreach( $gallery_image as $gallery ){
                $filePath = public_path($gallery->name);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
            if (File::exists('uploads/product/back_image/' . $delete->back_image)) {
                File::delete('uploads/product/back_image/' . $delete->back_image);
            }
            if (File::exists('uploads/product/thumb_image/' . $delete->thumb_image)) {
                File::delete('uploads/product/thumb_image/' . $delete->thumb_image);
            }
            $notification = array(
                'message'    => 'Prodcut is Permanent Deleted',
                'alert-type' => 'error'
            );
            $delete->delete();
            return redirect()->route('trash-manage-product')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function product_detail(string $id)
    {   
        $product_detail = Product::where('id', $id)->first();
        $reviews        = Review::where('product_id', $id)->get();   
        return view('backend.pages.product.details', compact('product_detail', 'reviews'));
    }

}
