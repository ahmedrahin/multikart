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

}
