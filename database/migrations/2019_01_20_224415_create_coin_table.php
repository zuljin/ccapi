<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin', function (Blueprint $table) 
        {
            // "id": 2,                                         OK  id  (my own id)
            // "name": "Ethereum",                              OK  name
            // "symbol": "ETH",                                 OK  symbol
            // "logo": null,                                    KO  not found in JSON
            // "rank": 2,                                       OK  cmc_rank
            // "price_usd": "719.98600000",                     OK  quote.USD.price
            // "price_btc": "0.07797240",                       KO  not found in JSON
            // "24h_volume_usd": 3014730000,                    OK  qoute.USD.volume_24h         
            // "market_cap_usd": 71421998446,   	            OK  qoute.USD.market_ca
            // "available_supply": 99199149,                    OK  circulating_supply
            // "total_supply": 99199149,                        OK  total_supply
            // "percent_change_1h": "0.28000000",               OK  qoute.USD.percent_change_1h
            // "percent_change_24h": "5.52000000",              OK  qoute.USD.percent_change_1h
            // "percent_change_7d": "14.58000000",              OK  qoute.USD.percent_change_1h
            // "created_at": "2018-05-03T08:54:02+00:00",       OK  date_added or default laravel
            // "updated_at": "2018-05-03T08:54:02+00:00"        OK  last_updated or default laravel

            $table->increments('id');             
            $table->string('name', 250)->charset('utf8')->nullable();
            $table->string('symbol', 10)->charset('utf8')->nullable();
            $table->string('logo', 10)->charset('utf8')->default('')->nullable();
            $table->integer('rank')->nullable();
            $table->double('price_usd')->nullable();
            $table->double('price_btc')->default(null)->nullable();
            $table->double('24h_volume_usd')->nullable();
            $table->double('market_cap_usd')->nullable();
            $table->double('available_supply')->nullable();
            $table->double('total_supply')->nullable();
            $table->float('percent_change_1h')->nullable();
            $table->float('percent_change_24h')->nullable();
            $table->float('percent_change_7d')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
    */

    public function down()
    {
        Schema::dropIfExists('coin');
    }
}