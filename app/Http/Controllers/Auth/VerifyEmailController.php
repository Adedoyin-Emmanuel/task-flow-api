<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\TokenRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;



class VerifyEmailController extends Controller
{


        protected $tokenRepository;

        public function __construct(TokenRepository $tokenRepository)
        {
            $this->tokenRepository = $tokenRepository;
        }


        public function verify(Request $request)
        {
            $token = $request->token;

            Log::info($token);

            $tokenData = $this->tokenRepository->findToken($token);



            Log::info($tokenData);
            if (!$tokenData) {
                return response()->json([
                    "success" => false,
                    "message" => "Invalid token"
                ], 400);
            }

            $user = User::find($tokenData->user_id);

            $user->email_verified_at = now();
            $user->verified = true;
            $user->save();

            $this->tokenRepository->deleteToken($token);

            return response()->json([
                "success" => true,
                "message" => "Email verified successfully"
            ]);
    }
}
