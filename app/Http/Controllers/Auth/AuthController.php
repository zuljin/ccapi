<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', [ 'except' => [ 'authenticate' ]]);
        $this->middleware('guest')->except('logout');
    }

    /**
    * @todo 
    **/

    public function authenticate( Request $request )
	{
        try
		{
            $credentials = $request->only('username', 'password');

            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json( ['message' => [ 'Unauthorized' ] ] , 401);
            }
        
            return response()->json([
                'token' => $token,
                'expires' => auth('api')->factory()->getTTL() * 60,
            ]);
        }
		catch (JWTException $e)
		{
			return response()->json( ['message' => [ 'General Error auth system' ] ], 500);
		}
        
	}


}
