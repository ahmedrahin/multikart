<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;use Brian2694\Toastr\ToastrServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Validation\Rule;
use File;
use Image;
use Auth;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a all user list.
     */
    public function manage_user()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $userList = User::orderBy('name', 'asc')->where('status', '=', 1)->orWhere('status', '=', 2)->get();
            return Datatables::of($userList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('image',function($data){
                    if( !is_null( $data->image ) ){
                        return "<img src='". asset('uploads/user/' . $data->image) ."' alt='' class='img'>";
                        }
                    else {
                        return "<img src='". asset('backend/images/default.jpg') ."' alt='' class='img'>"; 
                    }
                })
                ->addColumn('user_name',function($data){
                    return $data->name;
                })
                ->addColumn('email_address',function($data){
                    return $data->email;
                })
                ->addColumn('phone',function($data){
                    if( !is_null($data->phone) ){
                        return $data->phone;
                    }else {
                        return "-";
                    }
                })
                ->addColumn('user_role',function($data){
                    if( $data->role == 1 ){
                        return '<div class="text-danger">Admin</div>';
                    }else if ($data->role == 3) {
                        return "<span class='subadmin'>Sub-Admin</span>";
                    }else if ($data->role == 2) {
                        return "<span class='user'>User</span>";
                    }
                })
                ->addColumn('status',function($data){
                    if( $data->status == 1 ){
                        return '<div class="badge bg-success">Active</div>';
                    }
                    else if( $data->status == 0 || $data->status == 2 ){
                        return '<div class="badge bg-danger">Inactive</div>';
                    }
                })
                ->addColumn('action', function($data) {
                    return  '<a class="btn btn-primary br-0" href="' . route('edit-user', $data->id) . '">
                                <i class="bi bi-pencil-fill"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger br-0" data-bs-toggle="modal" data-bs-target="#user' . $data->id . '"><span class="cancell">&#10060</span></button>';
                })
                
                ->rawColumns(['sl','image','user_name','email_address','phone' ,'user_role','status', 'action'])
                ->make(true);
            }

            $userList = User::orderBy('name', 'asc')->where('status', '=', 1)->orWhere('status', '=', 2)->get();
        return view('backend.pages.user.manage', compact("userList"));
    }

    /**
     * Edit the user info
     */
    public function edit(string $id)
    {
        $edit = User::find($id);
        if(!is_null($edit)){
            $editData  = User::where('id', $edit->id)->first();
            return view('backend.pages.user.edit', compact('editData'));
        }
    }

    /**
     * Edit the user profile
     */
    public function profileEdit(string $id)
    {
        $edit = User::find($id);
        if(!is_null($edit)){
            $editData  = User::where('id', $edit->id)->first();
            return view('backend.pages.user.profile', compact('editData'));
        }
    }

    /**
     * Update the user information.
     */
    public function userInfo(Request $request, string $id)
    {
        $userInfo = User::find($id);

        if( !is_null( $userInfo ) ){
            // validation
            $request->validate([
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($userInfo->id),
                    function ($attribute, $value, $fail) {
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $fail('The '.$attribute.' must be a valid email address.');
                        }
                    },
                ],
                'phone' => 'nullable|numeric',
            ]);

            $userInfo->name          = $request->name;
            $userInfo->email         = $request->email;
            $userInfo->phone         = $request->phone;
            $userInfo->phone         = $request->phone;
            $userInfo->address_line1 = $request->address_line_1;
            $userInfo->address_line2 = $request->address_line_2;
            $userInfo->division_id   = $request->state_id;
            $userInfo->district_id   = $request->district_id;
            $userInfo->country_id    = $request->country_id;
            $userInfo->zipCode       = $request->zip_code;

            // Notification
            Toastr::success('Your Information is Updated', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            $userInfo->save();
            return redirect()->back();
        }

    }

    /**
     * Set user profile picture
     */
    public function profilePic(Request $request, string $id)
    {
        $userImg = User::find($id);
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg,gif',    
        ]);

        $uploadedImage = $request->file('image');
        $hadProfilePic = !empty($userImg->image);

        if ($uploadedImage) {
            // Remove the previous image from storage
            if ($hadProfilePic && File::exists(public_path('uploads/user/' . $userImg->image))) {
                File::delete(public_path('uploads/user/' . $userImg->image));
            }

            $imageName     = time() . '-user.' . $uploadedImage->getClientOriginalExtension();
            $imageLocation = public_path('uploads/user/' . $imageName);

            // Save the uploaded image
            Image::make($uploadedImage)->save($imageLocation);
            $userImg->image = $imageName;

            if ($hadProfilePic) {
                Toastr::success('Profile Picture is Updated', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            } else {
                Toastr::success('Profile Picture is Uploaded', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
            }
        } else {
            Toastr::error('Profile Picture is Not Uploaded', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
        }

        $userImg->save();
        return redirect()->back();
    }

    /**
     * Remove the user profile picture.
     */
    public function removeProfilePic(Request $request, string $id){

        $remove_img = User::find($id);

        if (!is_null($remove_img)) {
            $hadProfilePic = !empty($remove_img->image);

            if ($hadProfilePic && $request->has('remove_image')) {
                // Remove the image from storage
                if (File::exists(public_path('uploads/user/' . $remove_img->image))) {
                    File::delete(public_path('uploads/user/' . $remove_img->image));
                }

                // Remove the image reference from the database
                $remove_img->image = null;

                // Notification
                Toastr::error('Profile Picture is Removed', '', ["positionClass" => "toast-top-right", "closeButton" => true]);
                $remove_img->save();
                return redirect()->back();
            }
        }
    }

    /**
     * Update the user info
     */
    public function update(Request $request, string $id)
    {
        $updateUser = User::find($id);
        if( !is_null($updateUser) ){
            $request->validate([
                "role"   => "required",
                "status" => "required"
            ],[
                "role"   => "Please select a user role",
                "status" => "Please select a user status",
            ]);

            $updateUser->role   = $request->role;
            $updateUser->status = $request->status;

            // Notification
            if( $request->has('role') && $request->has('status') ){
                session::flash('alert-type', 'info');
                session::flash('message', 'The User Information is Updated');
            }
            $updateUser->save();
            return redirect()->route('manage-user');
        }
        
    }

    /**
     * Show inactive user.
     */
    public function trash_manage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $userList = User::orderBy('name', 'asc')->where('status', '=', 0)->get();
            return Datatables::of($userList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('image',function($trash){
                    if( !is_null( $trash->image ) ){
                        return "<img src='". asset('uploads/user/' . $trash->image) ."' alt='' class='img'>";
                        }
                    else {
                        return "<img src='". asset('backend/images/default.jpg') ."' alt='' class='img'>"; 
                    }
                })
                ->addColumn('user_name',function($trash){
                    return $trash->name;
                })
                ->addColumn('email_address',function($trash){
                    return $trash->email;
                })
                ->addColumn('phone',function($trash){
                    if( !is_null($trash->phone) ){
                        return $trash->phone;
                    }else {
                        return "-";
                    }
                })
                ->addColumn('user_role',function($trash){
                    if( $trash->role == 1 ){
                        return '<div class="text-danger">Admin</div>';
                    }else if ($trash->role == 3) {
                        return "<span class='subadmin'>Sub-Admin</span>";
                    }else if ($trash->role == 2) {
                        return "<span class='user'>User</span>";
                    }
                })
                ->addColumn('status',function($trash){
                    if( $trash->status == 1 ){
                        return '<div class="badge bg-success">Active</div>';
                    }
                    else if( $trash->status == 0 ){
                        return '<div class="badge bg-danger">Deactive</div>';
                    }
                })
                ->addColumn('action', function($trash) {
                    $actionButtons = '<div class="btn-group">
                        <form action="' . route('restore-user', $trash->id) . '" class="btn btn-primary" method="POST">' .
                            csrf_field() .
                            '<button type="submit">Active</button>' .
                        '</form>' .
                        '<form action="' . route('destroy-user', $trash->id) . '" method="POST" class="btn btn-danger">' .
                            csrf_field() .
                            @method_field("DELETE").
                            '<button type="submit">Delete</button>' .
                        '</form>' .
                    '</div>';
                    
                    return  $actionButtons;
                })
                
                ->rawColumns(['sl','image','user_name','email_address','phone' ,'user_role','status', 'action'])
                ->make(true);
            }

        $trashList = User::orderBy('name', 'asc')->where('status', 0)->get();
        return view('backend.pages.user.trash', compact('trashList'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function trash(string $id)
    {
        $trash = User::find($id);
        if(!is_null($trash)){
            $trash->status = 0;

            // Notification
            session::flash('alert-type', 'warning');
            session::flash('message', 'The User id is Deactived');
            $trash->save();
            return redirect()->route('manage-user');
        }
    }

     /**
     * Restore the user.
     */
    public function restore(string $id)
    {
        $restore = User::find($id);
        if(!is_null($restore)){
            $restore->status = 1;
            // Notification
            session::flash('alert-type', 'info');
            session::flash('message', 'The User is Actived');
            $restore->save();
            return redirect()->route('trash-manage-user');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = User::find($id);
        if(!is_null($delete)){

        session::flash('alert-type', 'error');
        session::flash('message', 'User is Permanent Deleted');
        $delete->delete();
        return redirect()->route('trash-manage-user');
        }
    }
}
