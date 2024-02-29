<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use Illuminate\Support\Facades\Session;
use File;
use Image;

class GenarelSettings extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $GenarelSettings = Settings::first();
        return view('backend.pages.genarel_settings.manage', compact('GenarelSettings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $setting = Settings::find(1);
        
        $setting->site_title = $request->site_title;
        $setting->number1 = $request->number1;
        $setting->number2 = $request->number2;
        $setting->email = $request->email;

         // fav icon
         if ($request->hasRemove) {
            // Check and delete old image
            if (File::exists('uploads/fav_logo/' . $setting->fav_icon)) {
                File::delete('uploads/fav_logo/' . $setting->fav_icon);
            }
            $setting->fav_icon = null;
        }
         else if( $request->hasFile('fav_icon') ){
            // check and delete old image
            if( File::exists( 'uploads/fav_logo/' . $setting->fav_icon ) ){
                File::delete( 'uploads/fav_logo/' . $setting->fav_icon);
            }

            // get image from user
            $image = $request->file('fav_icon');
            // change image name
            $img = time() . "-fav." . $image->getClientOriginalExtension();
            // set location
            $imgLocation = public_path('uploads/fav_logo/' . $img);

            // create image to the folder
            Image::make($image)->resize(32, 32)->save($imgLocation);
            // save the image name into the db
            $setting->fav_icon = $img;
        }

        // logo icon
        if ($request->hasLogoRemove) {
            // Check and delete old image
            if (File::exists('uploads/fav_logo/' . $setting->logo)) {
                File::delete('uploads/fav_logo/' . $setting->logo);
            }
            $setting->logo = null;
        }
         else if( $request->hasFile('logo') ){
            // check and delete old image
            if( File::exists( 'uploads/fav_logo/' . $setting->logo ) ){
                File::delete( 'uploads/fav_logo/' . $setting->logo);
            }

            // get image from user
            $image = $request->file('logo');
            // change image name
            $img = time() . "-fav." . $image->getClientOriginalExtension();
            // set location
            $imgLocation = public_path('uploads/fav_logo/' . $img);

            // create image to the folder
            Image::make($image)->save($imgLocation);
            // save the image name into the db
            $setting->logo = $img;
        }

        $setting->save();
        session::flash('alert-type', 'success');
        session::flash('message', 'Successfully Saved');
        return redirect()->back();
    }

}
