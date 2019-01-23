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

Route::group( [ 'prefix' => 'v1' ], function () 
{
    // Login and get JWT
	Route::post( 'auth',                            [	'as'    => 'auth.login',
                                                        'uses' 	=> 'Auth\AuthController@authenticate'] );
           
    //4) GET  - user portfolio:            resume user cryto trades         /user/{id}/portfolio
    //5) POST - add new trade:             add a new trade to a user        /user/{id}/trade
    
    // Grouping for coins requests
    Route::group( [ 'prefix' => 'coins', 'middleware' => 'jwt.auth' ], function () 
    {
        // Get coin list paginated (25)
        Route::get(	'',                             [   'as'    => 'coin.index',
                                                        'uses' 	=> 'CoinController@index'] );
        // Get coin historical by range date
        Route::get(	'{id}/historical/{from}/{to}',  [   'as'    => 'coin.historical',
                                                        'uses' 	=> 'CoinController@historical'] );
        // Get coin detail
        Route::get(	'{id}',                         [   'as'    => 'coin.show',
                                                        'uses' 	=> 'CoinController@show'] );

    });
    // Get coin list page number X. Little hack here. 
    // I need to put out of group to avoir coins/?page=X. paginate creates coins?page=X
    // Route::get( 'coins?page={1}', [      'as'    => 'coin.indexByPage',
    //                                      'uses' 	=> 'CoinController@index'] );
    
    
});
