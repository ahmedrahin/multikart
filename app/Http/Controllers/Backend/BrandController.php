<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\support\Str;
use Brian2694\Toastr\ToastrServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use File;
use Image;
use DataTables;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $sl;
    public function manage(Request $request)
    {   
        if( request()->ajax() ){
            $this->sl = 0;
            $brandList = DB::table('brands')->orderBy('name', 'asc')->where('status', '=', 1)->get();
            return Datatables::of($brandList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('image',function($data){
                    if( !is_null( $data->image ) ){
                        return "<img src='". asset('uploads/brands/' . $data->image) ."' alt='' class='img'>";
                        }
                    else {
                        return "<img src='". asset('backend/images/default.jpg') ."' alt='' class='img'>"; 
                    }
                })
                ->addColumn('brand_name',function($data){
                    return $data->name;
                })
                ->addColumn('description', function($data) {
                    return !is_null($data->description) ?
                        '<p>' . substr($data->description, 0, 50) . (strlen($data->description) >= 50 ? '...' : '') . '</p>' :
                        '<span class="no">empty description..</span>';
                })
                ->addColumn('action', function($data) {
                    return  '<a class="btn btn-primary br-0" href="' . route('edit-brand', $data->id) . '">
                                <i class="bi bi-pencil-fill"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger br-0" data-bs-toggle="modal" data-bs-target="#brand' . $data->id . '"><span class="cancell">&#10060</span></button>';
                })
                
                ->rawColumns(['sl','image','brand_name','description','action'])
                ->make(true);
            }

        $brandList = DB::table('brands')->orderBy('name', 'asc')->where('status', '=', 1)->get();
        return view('backend.pages.brand.manage', ['brandList' => $brandList]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('backend.pages.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $brand = new Brand;
        $request->validate([
            'name'  => 'required|unique:brands,name',
            'image' => 'mimes:jpeg,png,jpg,gif|max:1024',    
            // 'description'  => 'max:255|min:10' 
        ],[
            'name.required' => "The brand name field is required",
            'name.unique'   => "The brand name has already been taken",
            'image.max'     => "The image should not be more than 1 MB"
        ]);

        $brand->name        = $request->name;    
        $brand->slug        = Str::slug($request->name);    
        $brand->description = $request->description;   

        // Image Upload
        if( $request->image ){
            // get image from user
            $image = $request->file('image');

            // change image name
            $img = time() . '-brand.' . $image->getClientOriginalExtension();
            // set location
            $imgLocation = public_path('uploads/brands/' . $img);

            // create image to the folder
            Image::make($image)->resize(300, 250)->save($imgLocation);
            // save the image name into the db
            $brand->image = $img;
        }

        // Notification
        Toastr::success('Brand Added Successfully', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
        $brand->save();
        return redirect()->route('manage-brand');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = DB::table('brands')->find($id);
        if(!is_null($edit)){
            $editData  = DB::table('brands')->where('id', $edit->id)->first();
            return view('backend.pages.brand.edit', ['editData' => $editData]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = Brand::find($id);

        if( !is_null($update) ){
            $request->validate([
                'name'  => ['required', Rule::unique('brands')->ignore($update->id)],
                'image' => 'mimes:jpeg,png,jpg,gif|max:1024',    
                // 'description'  => 'max:255|min:10' 
            ],[
                'name.required' => "The brand name field is required",
                'name.unique'   => "The brand name has already been taken",
                'image.max'     => "The image should not be more than 1 MB"
            ]);

            $update->name         = $request->name;    
            $update->slug         = Str::slug($request->name);    
            $update->description  = $request->description;   

            // Image Update
            if( $request->image ){

                // check and delete old image
                if( File::exists( 'uploads/brands/' . $update->image ) ){
                    File::delete( 'uploads/brands/' . $update->image);
                }

                // get image from user
                $image = $request->file('image');

                // change image name
                $img = time() . '-brand.' . $image->getClientOriginalExtension();
                // set location
                $imgLocation = public_path('uploads/brands/' . $img);

                // create image to the folder
                Image::make($image)->resize(300, 250)->save($imgLocation);
                // save the image name into the db
                $update->image = $img;
            }   
            
            // Notification
            Toastr::info('Brand Information Updated', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            $update->save();
            return redirect()->route('manage-brand');
        }
    }

    // Delete Brand Image from database
    public function remove_image(Request $request, string $id)
    {
            $remove_img = Brand::find($id);
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
            $brandList = DB::table('brands')->orderBy('name', 'asc')->where('status', '=', 0)->get();
            return Datatables::of($brandList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                        return $this->sl = $this->sl+1;
                })
                ->addColumn('image',function($trash){
                    if( !is_null( $trash->image ) ){
                        return "<img src='". asset('uploads/brands/' . $trash->image) ."' alt='' class='img'>";
                        }
                    else {
                        return "<img src='". asset('backend/images/default.jpg') ."' alt='' class='img'>"; 
                    }
                })
                ->addColumn('brand_name',function($trash){
                    return $trash->name;
                })
                ->addColumn('description', function($trash) {
                    return !is_null($trash->description) ?
                        '<p>' . substr($trash->description, 0, 50) . (strlen($trash->description) >= 50 ? '...' : '') . '</p>' :
                        '<span class="no">empty description..</span>';
                })
                ->addColumn('action', function($trash) {
                    $actionButtons = '<div class="btn-group">
                        <form action="' . route('restore-brand', $trash->id) . '" class="btn btn-primary" method="POST">' .
                            csrf_field() .
                            '<button type="submit">Restore</button>' .
                        '</form>' .
                        '<form action="' . route('destroy-brand', $trash->id) . '" method="POST" class="btn btn-danger">' .
                            csrf_field() .
                            method_field('DELETE') .
                            '<button type="submit">Permanent Delete</button>' .
                        '</form>' .
                    '</div>';
                    
                    return  $actionButtons;
                })
                
                ->rawColumns(['sl','image','brand_name','description','action'])
                ->make(true);
            }

        $trashList = DB::table('brands')->orderBy('name', 'asc')->where('status', '=', 0)->get();
        return view('backend.pages.brand.trash', compact('trashList'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function trash(string $id)
    {
        $trash = DB::table('brands')->find($id);
        if(!is_null($trash)){
            $trash = [ 'status' => 0 ];
            Toastr::warning('Brand is Deleted', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            DB::table('brands')->where('id', $id)->update($trash);
            return redirect()->route('manage-brand');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore(string $id)
    {
        $restore = DB::table('brands')->find($id);
        if(!is_null($restore)){
            $restore = [ 'status' => 1 ];
            Toastr::info('Brand is Restore', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            DB::table('brands')->where('id', $id)->update($restore);
            return redirect()->route('trash-manage-brand');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = DB::table('brands')->find($id);
        if(!is_null($delete)){
            Toastr::error('Brand is Permanent Deleted', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            DB::table('brands')->where('id', $id)->delete();
            return redirect()->route('trash-manage-brand');
        }
    }
}

