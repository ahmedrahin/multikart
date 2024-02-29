<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationValue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ProductVariation(){
        return $this->belongsTo(ProductVariation::class,'var_id');
    }

    // public function ProductAttribute(){
    //     return $this->hasMany(ProductAttribute::class, 'var_value_id');
    // }
}
