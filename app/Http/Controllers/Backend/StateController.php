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
use App\Http\Requests\stateFormRequest;
use DataTables;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $stateList = State::orderBy('name', 'asc')->where('status', 1)->get();
            return Datatables::of($stateList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('state_name',function($data){
                    return $data->name;
                })
                ->addColumn('priority',function($data){
                    return !is_null($data->priority_number) ? $data->priority_number : "0";
                })
                ->addColumn('country_name',function($data){
                    return $data->country->name;
                })
                ->addColumn('action', function($data) {
                    return  '<a class="btn btn-primary br-0" href="' . route('edit-state', $data->id) . '">
                                <i class="bi bi-pencil-fill"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger br-0" data-bs-toggle="modal" data-bs-target="#state' . $data->id . '"><span class="cancell">&#10060</span></button>';
                })
                
                ->rawColumns(['sl','state_name','priority', 'country_name','action'])
                ->make(true);
            }

        $stateList = State::orderBy('name', 'asc')->where('status', 1)->get();
        return view('backend.pages.state.manage', compact('stateList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $countries = Country::orderBy('name', 'asc')->where('status', 1)->get();
        return view('backend.pages.state.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(stateFormRequest $request)
    {
        $state                   = new State;
        // $request->validate();
        $state->name             = $request->name;
        $state->priority_number  = $request->priority_number;
        $state->country_id       = $request->country_id;

        session::flash('alert-type', 'success');
        session::flash('message', 'State Added Successfully');
        $state->save();
        return redirect()->route('manage-state');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = State::find($id);
        if(!is_null($edit)){
            $editData  = State::where('id', $edit->id)->first();
            $countries = Country::orderBy('name', 'asc')->where('status', 1)->get();
            return view('backend.pages.state.edit', compact('editData', 'countries'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = State::find($id);
        
        if(!is_null($update)){
            $request->validate([
                'name'       =>  'required',
                'country_id'  => 'required'
            ],[
                'name.required'          => 'The State name field is required.',

                'country_id.required'    => 'Please select a country'
            ]);
            $update->name             = $request->name;
            $update->priority_number  = $request->priority_number;
            $update->country_id       = $request->country_id;

            session::flash('alert-type', 'info');
            session::flash('message', 'State Information Updated');
            $update->save();
            return redirect()->route('manage-state');
        }
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function trash_manage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $stateList = State::orderBy('name', 'asc')->where('status', 0)->get();
            return Datatables::of($stateList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('state_name',function($trash){
                    return $trash->name;
                })
                ->addColumn('priority',function($trash){
                    return !is_null($trash->priority_number) ? $trash->priority_number : "0";
                })
                ->addColumn('country_name',function($trash){
                    return $trash->country->name;
                })
                ->addColumn('action', function($trash) {
                    $actionButtons = '<div class="btn-group">
                        <form action="' . route('restore-state', $trash->id) . '" class="btn btn-primary" method="POST">' .
                            csrf_field() .
                            '<button type="submit">Restore</button>' .
                        '</form>' .
                        '<form action="' . route('destroy-state', $trash->id) . '" method="POST" class="btn btn-danger">' .
                            csrf_field() .
                            '<button type="submit">Permanent Delete</button>' .
                        '</form>' .
                    '</div>';
                    
                    return  $actionButtons;
                })
                
                ->rawColumns(['sl','state_name','priority', 'country_name','action'])
                ->make(true);
            }

        $trashList = State::orderBy('name', 'asc')->where('status', 0)->get();
        return view('backend.pages.state.trash', compact('trashList'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function trash(string $id)
    {
        $trash = State::find($id);
        if(!is_null($trash)){
            $trash->status = 0;

            session::flash('alert-type', 'warning');
            session::flash('message', 'The State is Deleted');
            $trash->save();
            return redirect()->route('manage-state');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore(string $id)
    {
        $restore = State::find($id);
        if(!is_null($restore)){
            $restore->status = 1;

            session::flash('alert-type', 'info');
            session::flash('message', 'The State is Restore');
            $restore->save();
            return redirect()->route('trash-manage-state');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = State::find($id);
        if(!is_null($delete)){

            session::flash('alert-type', 'error');
            session::flash('message', 'State is Permanent Deleted');
            $delete->delete();
            return redirect()->route('trash-manage-state');
        }
    }
}
