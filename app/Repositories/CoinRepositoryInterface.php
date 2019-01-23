<?php

namespace App\Repositories;

use App\Models\Coin;

interface CoinRepositoryInterface
{
    function getById( $id ): Coin;
    function getAllPaginated( $elementsByPage, $page );
}