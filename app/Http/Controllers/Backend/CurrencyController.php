<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $currencyList = Currency::all();
        return view('backend.pages.currency.manage', ['currencyList' =>$currencyList]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add_edit(Request $request, $id=null)
    {
        if( $id == '' ){
            // validation
            $request->validate([
                'currencyName' => 'required',
                'exchangeRate' => 'numeric|required',
                'sign'         => 'required',
            ]);
            
            $currency = new Currency();
            $currency->currency_name = $request->currencyName;
            $currency->exchange_rate = $request->exchangeRate;
            $currency->sign          = $request->sign;

            $currency->save();
            session::flash('alert-type', 'success');
            session::flash('message', 'The New Currency is Added');
            return redirect()->back();
        }else {
            $currency = Currency::find($id);
        }

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
