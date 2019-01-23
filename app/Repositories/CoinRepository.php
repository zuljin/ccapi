<?php namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Coin;

class CoinRepository implements CoinRepositoryInterface {

    public function __construct() {
    }

    /**
     * Get Coin by Id
     * 
     * @param  int  $id coin identifier
     * @return Coin
    */

    public function getById ( $id )
    {
        return Coin::where('id', $id)->first();
    }

    /**
     * Return a paginated list of cryptocurrencies with important info to show, it
     * can return a specific page
     * 
     * @param  int  $elementsByPage     total elements by page
     * @param  int  $page               specific page
     * @return \Illuminate\Http\Collection
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