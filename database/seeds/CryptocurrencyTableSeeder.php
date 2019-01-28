<?php

use Illuminate\Database\Seeder;

use App\Models\Coin;

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
        echo "Getting data from coinmarketcap API and populate COIN table...\n";
        $data = $this->getDateFromCMCAPI();
        $data = json_decode($data, true);
        $this->populateCoins( $data );
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
        if( $statusCode != 200 )
            die("Request to coinmarketca was wrong!: " . $statusCode . "\n");

        return $response->getBody()->getContents();
    }

    /**
     * @param json $data    cryto coins info
     */

    protected function populateCoins ( $data )
    {
        if( empty( $data['data'] ) )
            die("Empty data :(\n");

        foreach( $data['data'] as $value )
        {
             Coin::create([
                'name'                  => isset( $value['name'] )                                  ? $value['name']                                : '',
                'symbol'                => isset( $value['symbol'] )                                ? $value['symbol']                              : '',
                'logo'                  => '',
                'rank'                  => isset( $value['cmc_rank'] )                              ? $value['cmc_rank']                            : '',    
                'price_usd'             => isset( $value['quote']['USD']['price'] )                 ? $value['quote']['USD']['price']               : null,
                'price_btc'             => null,
                '24h_volume_usd'        => isset( $value['quote']['USD']['volume_24h'] )            ? $value['quote']['USD']['volume_24h']          : null,
                'market_cap_usd'        => isset( $value['quote']['USD']['market_cap'] )            ? $value['quote']['USD']['market_cap']          : null,
                'available_supply'      => isset( $value['circulating_supply'] )                    ? $value['circulating_supply']                  : null,
                'total_supply'          => isset( $value['total_supply'] )                          ? $value['total_supply']                        : null,
                'percent_change_1h'     => isset( $value['quote']['USD']['percent_change_1h'] )     ? $value['quote']['USD']['percent_change_1h']   : null,
                'percent_change_24h'    => isset( $value['quote']['USD']['percent_change_24h'] )    ? $value['quote']['USD']['percent_change_24h']  : null,
                'percent_change_7d'     => isset( $value['quote']['USD']['percent_change_7d'] )     ? $value['quote']['USD']['percent_change_7d']   : null,
            ]);
        }
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
// "24h_volume_usd": 3014730000,                    OK  qoute.USD.volume_24h        
// "market_cap_usd": 71421998446,   	            OK  qoute.USD.market_cap
// "available_supply": 99199149,                    OK  circulating_supply
// "total_supply": 99199149,                        OK  total_supply
// "percent_change_1h": "0.28000000",               OK  qoute.USD.percent_change_1h
// "percent_change_24h": "5.52000000",              OK  qoute.USD.percent_change_24h
// "percent_change_7d": "14.58000000",              OK  qoute.USD.percent_change_7d
// "created_at": "2018-05-03T08:54:02+00:00",       OK  date_added or default laravel
// "updated_at": "2018-05-03T08:54:02+00:00"        OK  last_updated or default laravel