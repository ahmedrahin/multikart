<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function VariationValue(){
        return $this->belongsTo(VariationValue::class, 'value_id');
    }

    public function ProductVariation(){
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }

    public function Product(){
        return $this->belongsTo(Product::class, 'products_id');
    }

    public static function getPrice($id)
    {
        $regularPrices = ProductAttribute::where('products_id', $id)->pluck('regular_price');

        $maxPrice = $regularPrices->max();
        $minPrice = $regularPrices->min();

        // Handle null values if no regular prices found
        if ($maxPrice === null) {
            $maxPrice = 0; 
        }

        if ($minPrice === null) {
            $minPrice = 0; 
        }

        return [
            'maxPrice' => $maxPrice,
            'minPrice' => $minPrice
        ];
    }

    public static function getOfferPrice($id)
    {
        $regularPrices = ProductAttribute::where('products_id', $id)->pluck('offer_price');

        $maxPrice = $regularPrices->max();
        $minPrice = $regularPrices->min();

        // Handle null values if no regular prices found
        if ($maxPrice === null) {
            $maxPrice = 0; 
        }

        if ($minPrice === null) {
            $minPrice = 0; 
        }

        return [
            'maxPrice' => $maxPrice,
            'minPrice' => $minPrice
        ];
    }

}
