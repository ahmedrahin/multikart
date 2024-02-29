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

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {   
        if( request()->ajax() ){
            $this->sl = 0;
            $countryList = Country::orderBy('name', 'asc')->where('status', 1)->get();
            return Datatables::of($countryList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('country_name',function($data){
                    return $data->name;
                })
                ->addColumn('action', function($data) {
                    return  '<a class="btn btn-primary br-0" href="' . route('edit-country', $data->id) . '">
                                <i class="bi bi-pencil-fill"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger br-0" data-bs-toggle="modal" data-bs-target="#country' . $data->id . '"><span class="cancell">&#10060</span></button>';
                })
                
                ->rawColumns(['sl','country_name','action'])
                ->make(true);
            }

        $countryList = Country::orderBy('name', 'asc')->where('status', 1)->get();
        return view('backend.pages.country.manage', compact('countryList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {       
        $country        = new Country;

        $request->validate([
            'name'  =>  'required|unique:countries,name'
        ],[
            'name.required'  => 'The country  name field is required',
            'name.unique'    => 'The country name has already been taken'
        ]);

        $country->name  = $request->name;
        $country->slug  = Str::slug($request->name);
        $notification = array(
            'message'    => 'Country Added Successfully',
            'alert-type' => 'success'
        );
        $country->save();
        return redirect()->route('manage-country')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        $edit = Country::find($id);
        if(!is_null($edit)){
            $editData = Country::where('id', $edit->id)->first();
            return view('backend.pages.country.edit', compact('editData'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = Country::find($id);
        $request->validate([
            'name'  =>  ['required', Rule::unique('countries')->ignore($update->id)]
        ],[
            'name.required'  => 'The country  name field is required',
            'name.unique'    => 'The country name has already been taken'
        ]);
        if(!is_null($update)){
            $update->name   = $request->name;
            $update->slug   = Str::slug($request->name);

            $update->save();
            $notification = array(
                'message'    => 'Country Information Updated',
                'alert-type' => 'info'
            );
            return redirect()->route('manage-country')->with($notification);
        }
    }

       /**
     * Display the specified resource.
     */
    public function trash_manage()
    {
        if( request()->ajax() ){
            $this->sl = 0;
            $countryList = Country::orderBy('name', 'asc')->where('status', 0)->get();
            return Datatables::of($countryList)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('country_name',function($trash){
                    return $trash->name;
                })
                ->addColumn('action', function($trash) {
                    $actionButtons = '<div class="btn-group">
                        <form action="' . route('restore-country', $trash->id) . '" class="btn btn-primary" method="POST">' .
                            csrf_field() .
                            '<button type="submit">Restore</button>' .
                        '</form>' .
                        '<form action="' . route('destroy-country', $trash->id) . '" method="POST" class="btn btn-danger">' .
                            csrf_field() .
                            method_field('DELETE') .
                            '<button type="submit">Permanent Delete</button>' .
                        '</form>' .
                    '</div>';
                    
                    return  $actionButtons;
                })
                
                ->rawColumns(['sl','country_name','action'])
                ->make(true);
            }

        $trashList = Country::orderBy('name', 'asc')->where('status', 0)->get();
        return view('backend.pages.country.trash', compact('trashList'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function trash(string $id)
    {
        $trash = Country::find($id);
        if(!is_null($trash)){
            $trash->status = 0;
            $trash->save();
            $notification = array(
                'message'    => 'The Country is Deleted',
                'alert-type' => 'warning'
            );
            return redirect()->route('manage-country')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore(string $id)
    {
        $restore = Country::find($id);
        if(!is_null($restore)){
            $restore->status = 1;
            $restore->save();
            $notification = array(
                'message'    => 'The Country is Restore',
                'alert-type' => 'info'
            );
            return redirect()->route('trash-manage-country')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Country::find($id);
        if(!is_null($delete)){

            // State
            $state = State::where('country_id', $delete->id)->get();
            foreach( $state as $delState ){
                $delState->delete();
                // District
                $district = District::where('state_id', $delState->id)->get();
                foreach( $district as $delDistrict ){
                    $delDistrict->delete();
                }
            }

            $delete->delete();
            $notification = array(
                'message'    => 'Country is Permanent Deleted',
                'alert-type' => 'error'
            );
            return redirect()->route('trash-manage-country')->with($notification);
        }
    }
}
