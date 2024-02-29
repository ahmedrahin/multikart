<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_id',
        'base_charge',
        'provider_name',
        'provider_charge',
        'status'
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'base_id');
    }
}
