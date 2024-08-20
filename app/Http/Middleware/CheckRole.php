<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;

class CheckRole
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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        $token = $request->cookie("auth_token");

        $dbToken = $this->tokenRepository->findToken($token);

        $userId = $dbToken->user_id;

        $user = $this->userRepository->findUser($userId);

        Log::info($user);


        Log::info($user->role);

        if($user->role !== $role){
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Insufficient permission'
            ], 403);
        }

        return $next($request);
    }
}
