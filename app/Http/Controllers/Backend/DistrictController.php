<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use Illuminate\support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use DataTables;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $districtList = District::orderBy('name', 'asc')->where('status', 1)->get();
            return Datatables::of($districtList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('district_name',function($data){
                    return $data->name;
                })
                ->addColumn('state_name',function($data){
                    return $data->state->name;
                })
                ->addColumn('action', function($data) {
                    return  '<a class="btn btn-primary br-0" href="' . route('edit-district', $data->id) . '">
                                <i class="bi bi-pencil-fill"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger br-0" data-bs-toggle="modal" data-bs-target="#district' . $data->id . '"><span class="cancell">&#10060</span></button>';
                })
                
                ->rawColumns(['sl', 'district_name', 'state_name', 'action'])
                ->make(true);
            }

        $districtList = District::orderBy('name', 'asc')->where('status', 1)->get();
        return view('backend.pages.district.manage', compact('districtList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $state = State::orderBy('name', 'asc')->where('status', 1)->get();
        return view('backend.pages.district.create', compact('state'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $district             = new District;

        $this->validate($request, [
            'name'     => 'required|unique:districts,name',
            'state_id' => 'required'
        ],[
            'name.required'     => 'The district name field is required ',
            'state_id.required' => 'Please Select a State Name'
        ]);

        $district->name       = $request->name;
        $district->state_id   = $request->state_id;
        
        session()->flash('alert-type', 'success');
        session()->flash('message', 'District Added Successfully');
        $district->save();
        return redirect()->route('manage-district');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = District::find($id);
        if(!is_null($edit)){
            $editData  = District::where('id', $edit->id)->first();
            $state     = State::orderBy('name', 'asc')->where('status', 1)->get();
            return view('backend.pages.district.edit', compact('editData', 'state'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = District::find($id);
        if(!is_null($update)){
            $this->validate($request, [
                'name'     => ['required', Rule::unique('districts')->ignore($update->id)],
                'state_id' => 'required'
            ],[
                'name.required'     => 'The district name field is required ',
                'state_id.required' => 'Please Select a State Name'
            ]);
            $update->name       = $request->name;
            $update->state_id   = $request->state_id;

            session()->flash('alert-type', 'info');
            session()->flash('message', 'District Information Updated');
            $update->save();
            return redirect()->route('manage-district');
        }
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function trash_manage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $districtList = District::orderBy('name', 'asc')->where('status', 0)->get();
            return Datatables::of($districtList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('district_name',function($trash){
                    return $trash->name;
                })
                ->addColumn('state_name',function($trash){
                    return $trash->state->name;
                })
                ->addColumn('action', function($trash) {
                    $actionButtons = '<div class="btn-group">
                        <form action="' . route('restore-district', $trash->id) . '" class="btn btn-primary" method="POST">' .
                            csrf_field() .
                            '<button type="submit">Restore</button>' .
                        '</form>' .
                        '<form action="' . route('destroy-district', $trash->id) . '" method="POST" class="btn btn-danger">' .
                            csrf_field() .
                            method_field('DELETE') .
                            '<button type="submit">Permanent Delete</button>' .
                        '</form>' .
                    '</div>';
                    
                    return  $actionButtons;
                })
                
                ->rawColumns(['sl', 'district_name', 'state_name', 'action'])
                ->make(true);
            }

        $trashList = District::orderBy('name', 'asc')->where('status', 0)->get();
        return view('backend.pages.district.trash', compact('trashList'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function trash(string $id)
    {
        $trash = District::find($id);
        if(!is_null($trash)){
            $trash->status = 0;

            session()->flash('alert-type', 'warning');
            session()->flash('message', 'The District is Deleted');
            $trash->save();
            return redirect()->route('manage-district');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore(string $id)
    {
        $restore = District::find($id);
        if(!is_null($restore)){
            $restore->status = 1;

            session()->flash('alert-type', 'info');
            session()->flash('message', 'The District is Restore');
            $restore->save();
            return redirect()->route('trash-manage-district');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = District::find($id);
        if(!is_null($delete)){
            session()->flash('alert-type', 'error');
            session()->flash('message', 'District is Permanent Deleted');
            $delete->delete();
            return redirect()->route('trash-manage-district');
        }
    }
}
