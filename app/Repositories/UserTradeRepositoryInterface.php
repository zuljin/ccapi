<?php

namespace App\Repositories;

use App\Models\UserTrade;

interface UserTradeRepositoryInterface
{
    function getPortfolio ( $id );
    function storeTrade ( $id, $data );
}