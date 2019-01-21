<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_trade', function (Blueprint $table) {

            // "coin_id": 2,
            // "user_id": 1,
            // "amount": "-2.2183",
            // "price_usd": "675.982",
            // "total_usd": -1499.5308706,
            // "notes": null,
            // "id": 3,
            // "created_at": "2018-05-03T09:00:07+00:00",
            // "updated_at": "2018-05-03T09:00:07+00:00",
            // "traded_at": "2018-04-20T16:40:51+00:00"

            $table->increments('id');
            $table->integer('coin_id')->unsigned()
                  ->foreign('coin_id')->references('id')->on('coin')->onDelete('cascade');
            $table->integer('user_id')->unsigned()
                  ->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->float('amount');
            $table->float('price_usd');
            $table->string('notes', 500)->charset('utf8')->nullable();
            $table->timestamp('traded_at');
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
        Schema::dropIfExists('user_trade');
    }
}
