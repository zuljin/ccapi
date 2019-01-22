<?php

namespace App\Repositories;

use App\Models\Coin;

interface CoinRepositotyInterface
{
    function getById( $id );
    function getAllPaginated( $elementsByPage, $page );
}