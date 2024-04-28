<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'ip_address'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    // how many items in the wishlist
    public static function totalItem(){
        $totalItem = 0;
        if( Auth::check() ){
            $wishlists = Wishlist::where('user_id', Auth::id())->get();
        }else {
            $wishlists = Wishlist::where('ip_address', request()->ip())->get();
        }

        $totalItem = $wishlists->count();
        return $totalItem;
    }

    //how many product in the wishlist
    public static function totalPsc(){
        if( Auth::check() ){
            $wishlists = Wishlist::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        }else {
            $wishlists = Wishlist::where('ip_address', request()->ip())->orderBy('created_at', 'desc')->get();
        }
        return $wishlists;
    }

}
