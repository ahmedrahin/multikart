<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use App\Models\VariationValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class VariationValueController extends Controller
{
  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'optionName' => 'required|unique:variation_values,option'
        ]);

        $option = new VariationValue();
        $option->var_id       = $request->var_id;
        $option->option       = $request->optionName;
        $option->option_value = $request->extra;

        $option->save();
        session::flash('alert-type', 'success');
        session::flash('message', 'The Variation Option is Added');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {  
         $update = VariationValue::find($id);
        // validation
        $request->validate([
            'optionName' => 'required'
        ]);

        $update->option       = $request->optionName;
        $update->option_value = $request->extra;

        $update->save();
        session::flash('alert-type', 'success');
        session::flash('message', 'The Variation Option is Updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = VariationValue::find($id);
        $delete->delete();
        session::flash('alert-type', 'error');
        session::flash('message', 'The Variation Option is Deleted');
        return redirect()->back();
    }
}
