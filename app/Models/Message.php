<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_id',
        'first_name',
        'last_name',
        'user_email',
        'phone',
        'message',
        'rep_message',
        'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
