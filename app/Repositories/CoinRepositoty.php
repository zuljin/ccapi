<?php namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Coin;

class CoinRepositoty implements CoinRepositotyInterface {

    public function __construct() {
    }

    /**
     * 
    */

    public function getById ( $id )
    {
        return Coin::where('id', $id)->first();
    }

    /**
     * 
     */
    public function getAllPaginated ( $elementsByPage, $page )
    {
        $fieldsToShow = [   'id', 
                            'name', 
                            'rank', 
                            'price_usd', 
                            'available_supply', 
                            'percent_change_24h'
                        ];
                        
        return  Coin::paginate( $elementsByPage, $fieldsToShow, 'page', $page );
    }
}