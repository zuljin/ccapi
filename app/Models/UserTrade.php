<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTrade extends Model
{
    protected $table = 'user_trade';

    protected $fillable = [
        'coin_id', 
        'user_id',
        'amount',
        'price_usd', 
        'total_usd',
        'notes',
        'traded_at',
    ];

    protected $dates = [ 'traded_at' ];

    protected $guarded = [];
}
