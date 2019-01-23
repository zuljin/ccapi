<?php namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\UserTrade;

class UserTradeRepository implements UserTradeRepositoryInterface {

    public function __construct() {
    }

    /**
     * 
    */

    public function getPortfolio ( $id )
    {
        return UserTrade::where('user_id', $id)
                        ->groupBy('coin_id')
                        ->selectRaw('coin_id, sum(amount) as amount, sum(price_usd) as price_usd')
                        ->get();
    }

    /**
     * 
    */

    public function storeTrade ( $id, $data ) 
    {
        \DB::beginTransaction(); 
        try 
        {
            $userTrade = UserTrade::create([
                            'coin_id'   => $data['coin_id'],
                            'user_id'   => (int) $id,
                            'amount'    => $data['amount'],
                            'price_usd' => $data['price_usd'],
                            'total_usd' => ($data['amount'] * $data['price_usd']),
                            'notes'     => !empty($data['notes']) ? $data['notes'] : '',
                            'traded_at' => Carbon::parse($data['traded_at'])->setTimezone('UTC'),
            ]);
        } 
        catch (\Exception $e) 
        { 
            \DB::rollback(); 
            return "Something was wrong";
        }
        \DB::commit();
        return $userTrade;
    }
}