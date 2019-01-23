<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Requests\CoinRequest;

use App\Repositories\CoinRepository;
use App\Repositories\CoinHistoricalRepository;

class CoinController extends Controller
{
    protected $elementsByPage   = 25;
    protected $initPage         = 1;

    /**
     * Return it has to return a paginated list of cryptocurrencies with important info to show
     * or and specific page
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
            $coins = (new CoinRepository())->getAllPaginated( $this->elementsByPage, $page );
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
     * @param  int          $id
     * @return \Illuminate\Http\JsonResponse
    */

    public function show ( CoinRequest $request, $id )
    {
        try
        {
            // Validation
            $validation = $request->validation( $request->rulesShow( $id ), $request->messages( $id ) );
            if( $validation !== true )
                return $validation;

            // Search and response
            $coin = (new CoinRepository())->getById($id);
            return response()->json( $coin, 200);
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
     * @param  int          $id
     * @param  string       $dateFrom
     * @param  string       $dateTo
     * @return \Illuminate\Http\JsonResponse
    */

    public function historical ( CoinRequest $request, $id, $dateFrom, $dateTo ) 
    {        
        // Validation
        $validation = $request->validation( $request->rulesHistorical( $id, $dateFrom, $dateTo ), $request->messages( $id ) );
        if( $validation !== true )
            return $validation;

        // Passing Dates to Carbon
        $dateFrom   = explode('-', $dateFrom);
        $dateTo     = explode('-', $dateTo);
        $dateFrom   = Carbon::create( $dateFrom[0], $dateFrom[1], $dateFrom[2] );
        $dateTo     = Carbon::create( $dateTo[0], $dateTo[1], $dateTo[2] );

        $coinHistorical = (new CoinHistoricalRepository())->getByIdAndDateRange ( $id, $dateFrom, $dateTo );
        return response()->json( ["historical" => $coinHistorical ], 200);
    }
}