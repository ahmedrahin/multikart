<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'brand_id',
        'category_id',
        'subCategory_id',
        'regular_price',
        'offer_price',
        'quantity',
        'sku_code',
        'short_details',
        'long_details',
        'video_link',
        'is_featured',
        'status',
        'tags',
        'thumb_image',
        'back_image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(Subcategory::class, "subCategory_id");
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function review(){
        return $this->hasMany(Review::class, 'product_id');
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    public function OrderVariation(){
        return $this->hasMany(OrderVariation::class, "product_id");
    }

    public function ProductAttribute(){
        return $this->hasMany(ProductAttribute::class, 'products_id');
    }
    

}
