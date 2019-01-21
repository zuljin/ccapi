<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $table = 'coin';

    protected $fillable = [
        'name', 
        'symbol', 
        'logo',
        'rank',
        'price_usd',
        'price_btc',
        '24h_volume_usd',
        'market_cap_usd',
        'available_supply',
        'total_supply',
        'percent_change_1h',
        'percent_change_24h',
        'percent_change_7d',
    ];

    protected $guarded = [];
}
