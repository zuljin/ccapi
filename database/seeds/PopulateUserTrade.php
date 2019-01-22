<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\Coin;
use App\Models\User;
use App\Models\UserTrade;

class PopulateUserTrade extends Seeder
{
    protected $notes = [    '', 
                            'Beetlejuice, Beetlejuice, Beetlejuice!', 
                            'To infinity…and beyond!',
                            'I know you are, but what am I?',
                            'You talkin’ to me?',
                            'Houston, we have a problem.',
                            'I’ll be back.',
                            'May the Force be with you',
                        ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=PopulateUserTrade

        // we will created some user trades between now and last 180 days, jut for the 3 first currency to
        // force trade with the same currency and make a meaningful 'groupby' queries a the fist moment

        User::get( [ 'id' ] )->each( function ( $user ) 
        { 
            $initTrades = rand(0,5);

            echo "User: " . $user->id . " Trades: " . $initTrades . "\n";
            for($initTrades; $initTrades>=1; $initTrades--) 
            {
                $coin = Coin::where( 'id', rand(1,3) )->get( [ 'id', 'price_usd' ] )->first();
                if($coin instanceof Coin)
                {
                    UserTrade::create([
                        'coin_id'   => $coin->id,
                        'user_id'   => $user->id,
                        'amount'    => ($coin->price_usd) * (mt_rand( 0, 50 ) / 5) ,    // totally random based on price_used
                        'price_usd' => $coin->price_usd,
                        'total_usd' => ($coin->price_usd) * (mt_rand( 0, 100 ) / 10),    // totally random based on price_used
                        'notes'     => $this->notes[ array_rand($this->notes) ],
                        'traded_at' => Carbon::now()->subDays(rand(1, 180)),
                    ]);   
                }
            }
        });
    }
}
