<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinHistorical extends Model
{
    protected $table = 'coin_historical';

    protected $fillable = [
        'coin_id', 
        'price_usd', 
        'snapshot_at',
    ];

    protected $dates = [ 'snapshot_at' ];

    protected $guarded = [];
}
