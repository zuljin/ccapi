<?php namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Requests\UserRequest;
use App\Repositories\UserTradeRepository;

class UserController extends Controller
{

    /**
     * Return a summary of crypto trades done by the user grouped by coin
     *
     * @param  UserRequest  $request
     * @param  int          $id         user identifier
     * @return \Illuminate\Http\JsonResponse
    */

    public function portfolio ( UserRequest $request, $id )
    {
        try
        {
            // Validation
            $validation = $request->validation( $request->rulesPortfolio( $id ), $request->messages( $id ) );
            if( $validation !== true )
                return $validation;

            $portfolio = (new UserTradeRepository())->getPortfolio ( $id );
            return response()->json( $portfolio, 200);
        }
        catch (\Exception $e)
        {
            return response()->json( [ 'message'  => [ $e->getMessage() . ' ' . $e->getFile() . '(' . $e->getLine() . ')'] ], 500);
        }
    }

    /**
     * Store in database a trade specified by the user and return it
     *
     * @param  UserRequest  $request
     * @param  int          $id         user identifier
     * @return \Illuminate\Http\JsonResponse
    */

    public function storeTrade ( UserRequest $request, $id )
    {
        // Validation
        $validation = $request->validation( $request->rulesStoreTrade( $id ), $request->messages( $id ) );
        if( $validation !== true )
            return $validation;
        
        // Insert into DB and response
        $trade = (new UserTradeRepository())->storeTrade( $id, $request->all() );
        return response()->json( $trade, 201);
    }
}
