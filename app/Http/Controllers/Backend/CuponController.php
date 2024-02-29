<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Cupon;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DataTables;

class CuponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $cupons = Cupon::orderBy('title', 'asc')->get();
            return Datatables::of($cupons)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('title',function($data){
                    return $data->title;
                })
                ->addColumn('code',function($data){
                    return $data->cupon_code;
                })
                ->addColumn('amount',function($data){
                    if( $data->type == 'percent' ){
                        return $data->discount_amount . "%";
                    }else {
                        return "৳" . $data->discount_amount;
                    }
                })
                ->addColumn('start',function($data){
                    if( !is_null( $data->start_at ) ){
                        return Carbon::parse($data->start_at)->format('M-d-y g:i a');
                    }else {
                        return "-";
                    }
                })
                ->addColumn('expire',function($data){
                    if( !is_null( $data->expires_at ) ){
                        return Carbon::parse($data->expires_at)->format('M-d-y g:i a');
                    }else {
                        return "-";
                    }
                })
                ->addColumn('status',function($data){
                    if( $data->status == 1 ){
                        return '<div class="badge bg-success">Active</div>';
                    }
                    else if( $data->status == 0 ){
                        return '<div class="badge bg-danger">Inactive</div>';
                    }
                })
                ->addColumn('action', function($data) {
                    return  '<a class="btn btn-primary br-0" href="' . route('edit-cupons', $data->id) . '">
                                <i class="bi bi-pencil-fill"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger br-0" data-bs-toggle="modal" data-bs-target="#coupon' . $data->id . '"><span class="cancell">&#10060</span></button>';
                })
                
                ->rawColumns(['sl', 'title', 'code', 'amount', 'start', 'expire', 'status', 'action'])
                ->make(true);
            }

        $cupons = Cupon::orderBy('title', 'asc')->get();
        return view('backend.pages.cupon.manage', compact('cupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.cupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:cupons,title',
            'code' => 'required|unique:cupons,cupon_code',
            'type' => 'required',
            'damount' => 'required',
            'start' => 'nullable|required_with:expire|date',
            'expire' => 'nullable|required_with:start|date|after:start',
        ],[
            'damount' => 'Please select discount amount',
            'expire.after' => 'The expire date must be after the start date',
        ]);

        $cupon = new Cupon();
        $cupon->title             = $request->title;
        $cupon->cupon_code        = $request->code;
        $cupon->discount_amount   = $request->damount;
        $cupon->type              = $request->type;
        $cupon->min_amount        = $request->mamount;
        $cupon->max_uses          = $request->uses;
        $cupon->max_uses_user     = $request->uses_user;
        $cupon->status            = $request->status;
        $cupon->start_at          = $request->start;
        $cupon->expires_at        = $request->expire;

        session::flash('alert-type', 'success');
        session::flash('message', 'The New Coupon Added');
        $cupon->save();
        return redirect()->route('manage-cupons');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Cupon::find($id);
        if(!is_null($edit)){
            $editData  = Cupon::where('id', $edit->id)->first();
            return view('backend.pages.cupon.edit', compact('editData'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = Cupon::find($id);
        if(!is_null($update)){
            $request->validate([
                'title'       => ['required', Rule::unique('cupons')->ignore($update->id)],
                'cupon_code'  => ['required', Rule::unique('cupons')->ignore($update->id)],
                'type'        => 'required',
                'damount'     => 'required',
                'start'       => 'nullable|required_with:expire|date',
                'expire'      => 'nullable|required_with:start|date|after:start',
            ],[
                'damount.required' => 'Please select discount amount',
                'expire.after' => 'The expire date must be after the start date',
            ]);
            
            $update->title             = $request->title;
            $update->cupon_code        = $request->cupon_code;
            $update->discount_amount   = $request->damount;
            $update->type              = $request->type;
            $update->min_amount        = $request->mamount;
            $update->max_uses          = $request->uses;
            $update->max_uses_user     = $request->uses_user;
            $update->status            = $request->status;
            $update->start_at          = $request->start;
            $update->expires_at        = $request->expire;

            session()->flash('alert-type', 'info');
            session()->flash('message', 'Coupon Information Updated');
            $update->save();
            return redirect()->route('manage-cupons');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Cupon::find($id);
        if(!is_null($delete)){
            session()->flash('alert-type', 'error');
            session()->flash('message', 'Coupon is Permanent Deleted');
            $delete->delete();
            return redirect()->route('manage-cupons');
        }
    }
}
