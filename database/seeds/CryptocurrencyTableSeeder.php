<?php

use Illuminate\Database\Seeder;

class CryptocurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // php artisan db:seed --class=CryptocurrencyTableSeeder

        echo "Getting data from coinmarketcap API\n";
        //$this->getDateFromCMCAPI();
    }

    /**
     * Connecting and getting data from cointmarketcap API
     */
    protected function getDateFromCMCAPI ()
    {
        $endpoint   = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
        $params     = '?start=1&limit=250&convert=USD';
        $key        = '&CMC_PRO_API_KEY=' . ENV('COINMARKETCAP_KEY', null);
            
        $client     = new GuzzleHttp\Client();
        $response   = $client->request('GET', $endpoint . $params . $key , [ ]);
        
        $statusCode = $response->getStatusCode();
        $content    = $response->getBody()->getContents();
    }
}


// MAPPING
// "id": 2,                                         OK  id (my own id)
// "name": "Ethereum",                              OK  name
// "symbol": "ETH",                                 OK  symbol
// "logo": null,                                    KO  not found in JSON
// "rank": 2,                                       OK  cmc_rank
// "price_usd": "719.98600000",                     OK  quote.USD.price
// "price_btc": "0.07797240",                       KO  not found in JSON
// "24h_volume_usd": 3014730000,                    OK  qoute.USD.volume_24H         
// "market_cap_usd": 71421998446,   	            OK  qoute.USD.market_ca
// "available_supply": 99199149,                    OK  circulating_supply
// "total_supply": 99199149,                        OK  total_supply
// "percent_change_1h": "0.28000000",               OK  qoute.USD.percent_change_1h
// "percent_change_24h": "5.52000000",              OK  qoute.USD.percent_change_1h
// "percent_change_7d": "14.58000000",              OK  qoute.USD.percent_change_1h
// "created_at": "2018-05-03T08:54:02+00:00",       OK  date_added or default laravel
// "updated_at": "2018-05-03T08:54:02+00:00"        OK  last_updated or default laravel