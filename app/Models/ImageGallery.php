<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'name',
    ];

    public function images()
    {
        return $this->belongsTo(Product::class);
    }
}
