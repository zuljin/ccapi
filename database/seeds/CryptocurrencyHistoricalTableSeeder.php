<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\Coin;
use App\Models\CoinHistorical;

class CryptocurrencyHistoricalTableSeeder extends Seeder
{
    /**
     * Run the database seeds
     *
     * Cryptocurrency Historical: this data doesn't have to be real, but realistic. 
     * You can implement a small algorithm that seeds the database starting with the real 
     * information got in the previous seed. At least 6 months of fake data should be calculated.
     *
     * @return void
    */
    
    public function run()
    {
        // php artisan db:seed --class=CryptocurrencyHistoricalTableSeeder

        // Iterate over the crypto currency
        Coin::get( [ 'id', 'price_usd' ] )->each( function ( $coin ) 
        {
            $period = CarbonPeriod::create( Carbon::now('Europe/Madrid')->subMonths(6), 
                                            Carbon::now('Europe/Madrid') );
            
            $firstTime = true;
            // Iterate over the period
            foreach (array_reverse($period->toArray()) as $date) 
            {
                if ( !$firstTime )
                {
                    $percentdiff      = (mt_rand( -100, 100 ) / 10);    // -10% until 10% from original value;
                    $coin->price_usd *= (1 + $percentdiff / 100);       // applying percent to current value
                }
                // firstTime, current price
                $firstTime = false;
                
                echo "[" . $coin->id . "] " . $date->format('Y-m-d') . " => " . $coin->price_usd  . "\n";
                
                CoinHistorical::create([
                    'coin_id'       => $coin->id,
                    'price_usd'     => $coin->price_usd,
                    'snapshot_at'   => $date,
                ]);
            }       
        });
    }
}
