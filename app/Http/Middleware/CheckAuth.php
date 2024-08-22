<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;



class CheckAuth
{
    protected $tokenRepository;
    protected $userRepository;

    public function __construct(TokenRepository $tokenRepository, UserRepository $userRepository){
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
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

        $user = $this->userRepository->getUser($dbToken->user_id);

        $request->attributes->set('role' , $user->role);
        $request->attributes->set('user_id' , $user->id);

        return $next($request);
    }
}
