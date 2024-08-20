<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TokenRepository;

use Exception;


class LoginController extends Controller
{

    protected $tokenRepository;

    public function __construct(TokenRepository $tokenRepository){
        $this->tokenRepository = $tokenRepository;
    }


    public function login(Request $request){

        try{

        $credentials = $request->only('email', 'password');


        if(Auth::attempt($credentials)){
            $user = Auth::user();

            $auth_token = $this->tokenRepository->createAuthenticationToken($user->id);

            $request->cookie();
            $COOKIE_EXPIRY = 60 * 24 * 7;

            $response = response()->json([
                'success' => true,
                'message' => 'Logged in successfully',
                'data' => [
                    'user' => $user,
                    'auth_token' => $auth_token
                ]
            ]);

            return $response->withCookie(cookie('auth_token', $auth_token, $COOKIE_EXPIRY, null, null, true, true, false, 'Strict'));

        }


        return response()->json([
            "success" => false,
            "message" => "Invalid credentials."
        ], 401);

    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 400);

    }
  }
}
