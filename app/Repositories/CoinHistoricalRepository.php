<?php namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\CoinHistorical;

class CoinHistoricalRepository implements CoinHistoricalRepositoryInterface {

    public function __construct() {
    }

    /**
     * 
    */

    public function getByIdAndDateRange ( $id, $dateFrom, $dateTo )
    {
        return CoinHistorical::where('coin_id', $id)
                      ->whereBetween('snapshot_at', [ $dateFrom, $dateTo ])
                      ->orderBy('snapshot_at', 'asc')
                      ->get( ['price_usd', 'snapshot_at'] );
    }
}