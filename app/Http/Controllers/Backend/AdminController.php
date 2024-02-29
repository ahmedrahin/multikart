<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.pages.dashboard');
    }

    /**
     * Display a all admin list.
     */
    public function manage_admin()
    { 
        if( request()->ajax() ){
            $this->sl = 0;
            $adminList = User::orderBy('name', 'asc')->whereNot('role', 2)->where('status', 1)->get();
            return Datatables::of($adminList)
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
        
        $adminList = User::orderBy('name', 'asc')->whereNot('role', 2)->where('status', 1)->get();
        return view('backend.pages.admin.manage', compact("adminList"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
