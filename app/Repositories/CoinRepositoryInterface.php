<?php

namespace App\Repositories;

use App\Models\Coin;

interface CoinRepositoryInterface
{
    function getById( $id );
    function getAllPaginated( $elementsByPage, $page );
}