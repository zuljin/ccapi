<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinHistoricalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        
        Schema::create('coin_historical', function (Blueprint $table) {

            // we will add-> coin_id to know coin owner     
            //"price_usd": "2962.04162456",
            //"snapshot_at": "2018-04-03T10:54:02+00:00"
            
            $table->integer('coin_id')->unsigned()
                  ->foreign('coin_id')->references('id')->on('coin')->onDelete('cascade');
            $table->float('price_usd')->nullable();
            $table->timestamp('snapshot_at');
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
        Schema::dropIfExists('coin_historical');
    }
}
