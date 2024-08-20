<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\TokenRepository;



class CheckAuth
{
    protected $tokenRepository;

    public function __construct(TokenRepository $tokenRepository){
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        $token = $request->cookie("auth_token");

        if(!$token){
            return response()->json(['success' => false, 'message' => 'Unauthorized. Invalid or expired token'], 401);
        }

        $dbToken = $this->tokenRepository->findToken($token);

        if(!$dbToken){
             return response()->json(['success' => false, 'message' => 'Unauthorized. Invalid or expired token'], 401);
        }


        return $next($request);
    }
}
