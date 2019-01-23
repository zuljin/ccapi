<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//////////////////
// API Version 1
Route::group( [ 'prefix' => 'v1' ], function () 
{
    //////////////////
    // Login and get JWT
	Route::post( 'auth',                            [	'as'    => 'auth.login',
                                                        'uses' 	=> 'Auth\AuthController@authenticate'] );
    //////////////////                                                 
    // COIN requests
    Route::group( [ 'prefix' => 'coins', 'middleware' => 'jwt.auth' ], function () 
    {
        // Get list paginated (25)
        Route::get(	'',                             [   'as'    => 'coin.index',
                                                        'uses' 	=> 'CoinController@index'] );
        // Get historical by range date
        Route::get(	'{id}/historical/{from}/{to}',  [   'as'    => 'coin.historical',
                                                        'uses' 	=> 'CoinController@historical'] );
        // Get detail
        Route::get(	'{id}',                         [   'as'    => 'coin.show',
                                                        'uses' 	=> 'CoinController@show'] );
    });
    //////////////////
    // USER requests
    Route::group( [ 'prefix' => 'user', 'middleware' => 'jwt.auth' ], function () 
    {   
        // Get a resume of cryto trades
        Route::get(	'{id}/portfolio',               [   'as'    => 'user.portfolio',
                                                        'uses' 	=> 'UserController@portfolio'] );
        // Add new trade
        Route::post(	'{id}/trade',               [   'as'    => 'user.addTrade',
                                                        'uses' 	=> 'UserController@storeTrade'] );
    });
    
});