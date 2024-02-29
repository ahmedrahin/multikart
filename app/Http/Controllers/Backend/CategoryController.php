<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use File;
use Image;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();
            return Datatables::of($categories)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('image',function($data){
                    if( !is_null( $data->image ) ){
                        return "<img src='". asset('uploads/categories/' . $data->image) ."' alt='' class='img'>";
                        }
                    else {
                        return "<img src='". asset('backend/images/default.jpg') ."' alt='' class='img'>"; 
                    }
                })
                ->addColumn('category_name',function($data){
                    return $data->name;
                })
                ->addColumn('action', function($data) {
                    return  '<a class="btn btn-primary br-0" href="' . route('edit-category', $data->id) . '">
                                <i class="bi bi-pencil-fill"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger br-0" data-bs-toggle="modal" data-bs-target="#category' . $data->id . '"><span class="cancell">&#10060</span></button>';
                })
                
                ->rawColumns(['sl', 'image', 'category_name', 'action'])
                ->make(true);
            }

        $categories = Category::orderBy('name', 'asc')->where('status', 1)->get();
        return view('backend.pages.category.manage', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('backend.pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new Category;

        // Validation
        $this->validate($request,[
            'name'  => 'required|unique:categories,name',
            'image' => 'mimes:jpeg,png,jpg,gif|max:1024',  
        ],[
            'name.required' => 'The cateogry name field is required',
            'name.unique'   => "The category name has already been taken",
            'image.max'     => "The image should not be more than 1 MB"
        ]);

        $category->name          = $request->name;
        $category->slug          = Str::slug($request->name);
        $category->description   = $request->description;

        // Image Upload
        if( $request->image ){
            // get image from user
            $image = $request->file('image');

            // change image name
            $img = time() . "-category." . $image->getClientOriginalExtension();
            // set location
            $imgLocation = public_path('uploads/categories/' . $img);

            // create image to the folder
            Image::make($image)->save($imgLocation);
            // save the image name into the db
            $category->image = $img;
        }

        // Notification
        session::flash('alert-type', 'success');
        session::flash('message', 'Category Added Successfully');
        $category->save();
        return redirect()->route('manage-category');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Category::find($id);
        if(!is_null($edit)){
            $editData  = Category::where('id', $edit->id)->first();
            return view('backend.pages.category.edit', compact('editData'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = Category::find($id);
        if( !is_null($update) ){
            // Validation
            $this->validate($request,[
                'name'  => ['required', Rule::unique('categories')->ignore($update->id)],
                'image' => 'mimes:jpeg,png,jpg,gif|max:1024',
            ],[
                'name.required' => 'The cateogry name field is required',
                'name.unique'   => "The category name has already been taken",
                'image.max'     => "The image should not be more than 1 MB"
            ]);

            $update->name         = $request->name;    
            $update->slug         = Str::slug($request->name);    
            $update->description  = $request->description;  
            
            // Image Update
            if( $request->image ){

                // check and delete old image
                if( File::exists( 'uploads/categories/' . $update->image ) ){
                    File::delete( 'uploads/categories/' . $update->image);
                }

                 // get image from user
                $image = $request->file('image');

                // change image name
                $img = time() . "-category." . $image->getClientOriginalExtension();
                // set location
                $imgLocation = public_path('uploads/categories/' . $img);

                // create image to the folder
                Image::make($image)->save($imgLocation);
                // save the image name into the db
                $update->image = $img;
            }

            // Notification
            session::flash('alert-type', 'info');
            session::flash('message', 'Category Information Updated');
            $update->save();
            return redirect()->route('manage-category');
        }
    }

     // Delete Brand Image from database
     public function remove_image(Request $request, string $id)
     {
         $remove_img = Category::find($id);
         if (!is_null($remove_img)) {
            // Remove Image
            if ($request->has('remove_image')) {
                // Remove the image from storage
                if (File::exists(public_path('uploads/brands/' . $remove_img->image))) {
                    File::delete(public_path('uploads/brands/' . $remove_img->image));
                }
                // Remove the image reference from the database
                $remove_img->image = null;
                $remove_img->save();
                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false], 404); 
     }

     /**
     * Show the form for editing the specified resource.
     */
    public function trash_manage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $categories = Category::orderBy('name', 'asc')->where('status', 0)->get();
            return Datatables::of($categories)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('image',function($trash){
                    if( !is_null( $trash->image ) ){
                        return "<img src='". asset('uploads/categories/' . $trash->image) ."' alt='' class='img'>";
                        }
                    else {
                        return "<img src='". asset('backend/images/default.jpg') ."' alt='' class='img'>"; 
                    }
                })
                ->addColumn('category_name',function($trash){
                    return $trash->name;
                })
                ->addColumn('action', function($trash) {
                    $actionButtons = '<div class="btn-group">
                        <form action="' . route('restore-category', $trash->id) . '" class="btn btn-primary" method="POST">' .
                            csrf_field() .
                            '<button type="submit">Restore</button>' .
                        '</form>' .
                        '<form action="' . route('destroy-category', $trash->id) . '" method="POST" class="btn btn-danger">' .
                            csrf_field() .
                            '<button type="submit">Permanent Delete</button>' .
                        '</form>' .
                    '</div>';
                    
                    return  $actionButtons;
                })
                
                ->rawColumns(['sl', 'image', 'category_name', 'action'])
                ->make(true);
            }

        $trashList = Category::orderBy('name', 'asc')->where('status', 0)->get();
        return view('backend.pages.category.trash', compact('trashList'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function trash(string $id)
    {
        $trash = Category::find($id);
        if(!is_null($trash)){
            $trash->status = 0;
            // Notification
            session::flash('alert-type', 'warning');
            session::flash('message', 'Category is Deleted');
            $trash->save();
            return redirect()->route('manage-category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore(string $id)
    {
        $restore = Category::find($id);
        if(!is_null($restore)){
            $restore->status = 1;
            // Notification
            session::flash('alert-type', 'info');
            session::flash('message', 'Category is Restore');
            $restore->save();
            return redirect()->route('trash-manage-category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Category::find($id);
        if(!is_null($delete)){
            // Notification
            session::flash('alert-type', 'error');
            session::flash('message', 'Category is Permanent Deleted');
            $delete->delete();
            return redirect()->route('trash-manage-category');
        }
    }
}
