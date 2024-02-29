<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Product(){
        return $this->belongsTo(Product::class);
    }

    public function VariationValue(){
        return $this->hasMany(VariationValue::class, 'var_id');
    }
}
