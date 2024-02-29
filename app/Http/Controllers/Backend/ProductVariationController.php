<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ProductVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function variation()
    {   
        $variations = ProductVariation::orderBy('id', 'asc')->get();
        $variationOption = ProductVariation::with('VariationValue')->orderBy('id', 'asc')->get();
        return view('backend.pages.product.variation', compact('variations', 'variationOption'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'VariationName' => 'required|unique:product_variations,var_name'
        ]);

        $ProductVariation = new ProductVariation();
        $ProductVariation->var_name = $request->VariationName;

        $ProductVariation->save();
        session::flash('alert-type', 'success');
        session::flash('message', 'The Variation is Added');
        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation
        $request->validate([
            'VariationName' => 'required|unique:product_variations,var_name'
        ]);

        $ProductVariation = ProductVariation::find($id);
        $ProductVariation->var_name = $request->VariationName;

        $ProductVariation->save();
        session::flash('alert-type', 'success');
        session::flash('message', 'The Variation is Updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = ProductVariation::find($id);
        $delete->delete();
        session::flash('alert-type', 'error');
        session::flash('message', 'The Variation is Deleted');
        return redirect()->back();
    }
}
