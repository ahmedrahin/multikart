<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderVariation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function VariationValue()
    {
        return $this->belongsTo(VariationValue::class,'var_val_id');
    }
}
