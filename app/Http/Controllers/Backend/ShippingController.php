<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use Illuminate\Support\Facades\Session;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {   
        $base_shipping = Shipping::orderBy('id', 'asc')->where('provider_name', NULL)->get();
        $shipping      = Shipping::orderBy('id', 'asc')->where('base_id', NULL)->get();
        $state         = State::orderby('name', 'asc')->get();
        return view('backend.pages.shipping.manage', ['base_shipping' => $base_shipping, 'state' => $state, 'shipping' => $shipping]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'base_location' => 'required',
            'charge'        => 'required|numeric',
        ]);

        $shipping                  = new Shipping();
        $shipping->base_id         = $request->base_location;
        $shipping->base_charge     = $request->charge;
        $shipping->status          = $request->status;
        $shipping->save();
        session::flash('alert-type', 'success');
        session::flash('message', 'The Base Shipping Method is Added');
        return redirect()->back();
    }

    public function curiourStore(Request $request)
    {
        $request->validate([
            'providerName'   => 'required',
            'shippingCharge' => 'required|numeric',
        ]);

        $shipping                  = new Shipping();
        $shipping->provider_name   = $request->providerName;
        $shipping->provider_charge = $request->shippingCharge;
        $shipping->status          = $request->status;
        
        $shipping->save();
        session::flash('alert-type', 'success');
        session::flash('message', 'The Shipping Method is Added');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        $request->validate([
            'base_location' => 'required',
            'charge'        => 'required|numeric'
        ]);
        $update = Shipping::find($id);
        if( !is_null($update) ){
            $update->base_id     = $request->base_location;
            $update->base_charge = $request->charge;
            $update->status      = $request->status;
            $update->save();
            session::flash('alert-type', 'info');
            session::flash('message', 'Update Base Shipping Method Information');
            return redirect()->back();
        }
    }

    public function curiourUpdate(Request $request, string $id)
    {   
        $request->validate([
            'providerName'   => 'required',
            'shippingCharge' => 'required|numeric',
        ]);

        $update = Shipping::find($id);
        if( !is_null($update) ){
            $update->provider_name    = $request->providerName;
            $update->provider_charge  = $request->shippingCharge;
            $update->status           = $request->status;
            $update->save();
            session::flash('alert-type', 'info');
            session::flash('message', 'Update Shipping Method Information');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $del_method = Shipping::find($id);
        $del_method->delete();
        session::flash('alert-type', 'error');
        session::flash('message', 'The Shipping Method is Deleted');
        return redirect()->back();
    }
}
