<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 250)->charset('utf8')->nullable();
            $table->string('name', 250)->charset('utf8')->nullable();
            $table->string('lastName', 250)->charset('utf8')->nullable();
            $table->string('email', 250)->charset('utf8')->nullable();
            $table->string('password', 250)->charset('utf8')->nullable();
            $table->string('remember_token', 250)->charset('utf8')->nullable();
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
        Schema::dropIfExists('user');
    }
}
