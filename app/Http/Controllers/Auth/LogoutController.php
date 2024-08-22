<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\TokenRepository
;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    protected $tokenRepository;


    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $this->tokenRepository->deleteAuthToken();

        return response()->json([
            "success" => true,
            "message" => "Logged out successfully"
        ]);
    }
}
