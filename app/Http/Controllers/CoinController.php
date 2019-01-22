<?php namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\CoinRequest;
use App\Repositories\CoinRepositoty;

class CoinController extends Controller
{
    protected $elementsByPage   = 25;
    protected $initPage         = 1;


    /**
     * Return the whole list of properties of a cryptocurrency for the given coin id .
     *
     * @param  CoinRequest  $request
     * @param  int          $id
     * @return \Illuminate\Http\JsonResponse
    */

    public function index( CoinRequest $request, $page = null )
    {
        try
        {   
            // Validation
            if ( !empty($page) )
            {
                $validation = $request->validation( $request->rulesIndex( $page ) );
                if( $validation !== true )
                    return $validation;
            }

            // Get list and response
            $page  = empty($page) ? $page : $this->initPage;
            $coins = (new CoinRepositoty())->getAllPaginated( $this->elementsByPage, $page );
            return response()->json( $coins, 200);
        }
        catch (\Exception $e)
        {
            return response()->json( [ 'message'  => [ $e->getMessage() . ' ' . $e->getFile() . '(' . $e->getLine() . ')'] ], 500);
        }
    }

    /**
     * Return the whole list of properties of a cryptocurrency for the given coin id .
     *
     * @param  CoinRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
    */

    public function show( CoinRequest $request, $id)
    {
        try
        {
            // Validation
            $validation = $request->validation( $request->rulesShow( $id ), $request->messages( $id ) );
            if( $validation !== true )
                return $validation;

            // Search and response
            $coin = (new CoinRepositoty())->getById($id);
            return response()->json( $coin, 200);
        }
        catch (\Exception $e)
        {
            return response()->json( [ 'message'  => [ $e->getMessage() . ' ' . $e->getFile() . '(' . $e->getLine() . ')'] ], 500);
        }
    }
}