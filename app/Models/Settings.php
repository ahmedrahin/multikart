<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'fav_icon',
        'logo',
        'site_title',
        'number1',
        'number2',
        'email',
    ];

    // shop title
    public static function site_title() {
        $site_title = Settings::select('site_title')->first();
        return $site_title; 
    }
    // shop fav icon
    public static function shop_fav() {
        $shop_fav = Settings::select('fav_icon')->first();
        return $shop_fav; 
    }
    // shop logo
    public static function shop_logo() {
        $shop_logo = Settings::select('logo')->first();
        return $shop_logo; 
    }
    // shop email
    public static function shop_email() {
        $shop_email = Settings::select('email')->first();
        return $shop_email; 
    }
    //call 1
    public static function call_1() {
        $call_1 = Settings::select('number1')->first();
        return $call_1; 
    }
    //call 1
    public static function call_2() {
        $call_2 = Settings::select('number2')->first();
        return $call_2; 
    }
}
