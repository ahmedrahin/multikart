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
use Illuminate\Support\Facades\DB;
use File;
use Image;
use DataTables;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {   
        if( request()->ajax() ){
            $this->sl = 0;
            $subCategories  = Subcategory::orderBy('name','asc')->where('status', 1)->get();
            return Datatables::of($subCategories)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('image',function($data){
                    if( !is_null( $data->image ) ){
                        return "<img src='". asset('uploads/sub-categories/' . $data->image) ."' alt='' class='img'>";
                        }
                    else {
                        return "<img src='". asset('backend/images/default.jpg') ."' alt='' class='img'>"; 
                    }
                })
                ->addColumn('subCategory_name',function($data){
                    return $data->name;
                })
                ->addColumn('category_name',function($data){
                    if( $data->parentCat->status == 1 ){
                        return $data->parentCat->name;
                    }else {
                        return '<span class="error">Uncategorize</span>';
                    }
                })
                ->addColumn('action', function($data) {
                    return  '<a class="btn btn-primary br-0" href="' . route('edit-subCategory', $data->id) . '">
                                <i class="bi bi-pencil-fill"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger br-0" data-bs-toggle="modal" data-bs-target="#subCategory' . $data->id . '"><span class="cancell">&#10060</span></button>';
                })
                
                ->rawColumns(['sl', 'image','subCategory_name', 'category_name', 'action'])
                ->make(true);
            }

        $subCategories    = Subcategory::orderBy('name','asc')->where('status', 1)->get();
        $parentCategories = Category::all();
        return view('backend.pages.sub-category.manage', compact('subCategories', 'parentCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::orderBy('name', 'asc')->where('status', 1)->get();
        return view('backend.pages.sub-category.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $subCategory = new Subcategory;

        // Validation
        $this->validate($request,[
            'name'         => 'required|unique:subcategories,name',
            'category_id'  => 'required',
            'image'        => 'mimes:jpeg,png,jpg,gif|max:1024',
        ],[
            'name.required'        => 'The cateogry name field is required',
            'category_id.required' => 'Please select a parent category',
            'image.max'            => "The image should not be more than 1 MB"
        ]);

        $subCategory->name        = $request->name;
        $subCategory->slug        = Str::slug($request->name);
        $subCategory->description = $request->description;
        $subCategory->category_id = $request->category_id;

        // Image Upload
        if( $request->image ){
            // get image from user
            $image = $request->file('image');

            // change image name
            $img = time() . "-subcategory." . $image->getClientOriginalExtension();
            // set location
            $imgLocation = public_path('uploads/sub-categories/' . $img);

            // create image to the folder
            Image::make($image)->save($imgLocation);
            // save the image name into the db
            $subCategory->image = $img;
        }

        // Notification
        session::flash('alert-type', 'success');
        session::flash('message', 'Sub-category Added Successfully');
        $subCategory->save();
        return redirect()->route('manage-subCategory');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Subcategory::find($id);
        if( !is_null($edit) ){
            $editData = Subcategory::where('id', $edit->id)->first();
            $parentCategories = Category::orderBy('name', 'asc')->where('status', 1)->get();
            return view('backend.pages.sub-category.edit', compact('editData', 'parentCategories'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = Subcategory::find($id);
        if( !is_null($update) ){

            // Validation
            $this->validate($request,[
                'name'         => ['required', Rule::unique('subcategories')->ignore($update->id)],
                'category_id'  => 'required',
                'image'        => 'mimes:jpeg,png,jpg,gif|max:1024',
            ],[
                'name.required'        => 'The cateogry name field is required',
                'category_id.required' => 'Please select a parent category',
                'image.max'            => "The image should not be more than 1 MB"
            ]);

            $update->name         = $request->name;
            $update->slug         = Str::slug($request->name);
            $update->description  = $request->description;
            $update->category_id  = $request->category_id;

            // Image Update
            if( $request->image ){

                // check and delete old image
                if( File::exists( 'uploads/sub-categories/' . $update->image ) ){
                    File::delete( 'uploads/sub-categories/' . $update->image);
                }

                 // get image from user
                $image = $request->file('image');

                // change image name
                $img = time() . "-subcategories." . $image->getClientOriginalExtension();
                // set location
                $imgLocation = public_path('uploads/sub-categories/' . $img);

                // create image to the folder
                Image::make($image)->save($imgLocation);
                // save the image name into the db
                $update->image = $img;
            }

            // Notification
            session::flash('alert-type', 'info');
            session::flash('message', 'Sub-category Information Updated');
            $update->save();
            return redirect()->route('manage-subCategory');
        }
    }

    // Delete Brand Image from database
    public function remove_image(Request $request, string $id)
    {
        $remove_img = Subcategory::find($id);
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
            $subCategories  = Subcategory::orderBy('name','asc')->where('status', 0)->get();
            return Datatables::of($subCategories)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('image',function($trash){
                    if( !is_null( $trash->image ) ){
                        return "<img src='". asset('uploads/sub-categories/' . $trash->image) ."' alt='' class='img'>";
                        }
                    else {
                        return "<img src='". asset('backend/images/default.jpg') ."' alt='' class='img'>"; 
                    }
                })
                ->addColumn('subCategory_name',function($trash){
                    return $trash->name;
                })
                ->addColumn('category_name',function($trash){
                    if( $trash->parentCat->status == 1 ){
                        return $trash->parentCat->name;
                    }else {
                        return '<span class="error">Uncategorize</span>';
                    }
                })
                ->addColumn('action', function($trash) {
                    $actionButtons = '<div class="btn-group">
                        <form action="' . route('restore-subCategory', $trash->id) . '" class="btn btn-primary" method="POST">' .
                            csrf_field() .
                            '<button type="submit">Restore</button>' .
                        '</form>' .
                        '<form action="' . route('destroy-subCategory', $trash->id) . '" method="POST" class="btn btn-danger">' .
                            csrf_field() .
                            method_field('DELETE') .
                            '<button type="submit">Permanent Delete</button>' .
                        '</form>' .
                    '</div>';
                    
                    return  $actionButtons;
                })
                
                ->rawColumns(['sl', 'image','subCategory_name', 'category_name', 'action'])
                ->make(true);
            }

        $trashList = Subcategory::orderBy('name', 'asc')->where('status', 0)->get();
        return view('backend.pages.sub-category.trash', compact('trashList'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function trash(string $id)
    {
        $trash = Subcategory::find($id);
        if(!is_null($trash)){
            $trash->status = 0;
            // Notification
            session::flash('alert-type', 'warning');
            session::flash('message', 'Sub-category is Deleted');
            $trash->save();
            return redirect()->route('manage-subCategory');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore(string $id)
    {
        $restore = Subcategory::find($id);
        if(!is_null($restore)){
            $restore->status = 1;
            // Notification
            session::flash('alert-type', 'info');
            session::flash('message', 'Sub-category is Restore');
            $restore->save();
            return redirect()->route('trash-manage-subCategory');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Subcategory::find($id);
        if(!is_null($delete)){
            // Notification
            session::flash('alert-type', 'error');
            session::flash('message', 'Category is Permanent Deleted');
            $delete->delete();
            return redirect()->route('trash-manage-subCategory');
        }
    }
    
}
