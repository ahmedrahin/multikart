<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'addressLine1',
        'addressLine2',
        'district_id',
        'division_id',
        'country_id',
        'zip_code',
        'amount',
        'paid_amount',
        'shipping_method',
        'cupon_code',
        'status',
        'transaction_id',
        'currency',
        'order_date',
        'order_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class, "division_id");
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }

}
