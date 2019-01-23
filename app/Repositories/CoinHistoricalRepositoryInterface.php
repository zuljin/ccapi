<?php

namespace App\Repositories;

use App\Models\CoinHistorical;

interface CoinHistoricalRepositoryInterface
{
    function getByIdAndDateRange ( $id, $dateFrom, $dateTo );
}