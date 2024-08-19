<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Repositories\TokenRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class RegisterController extends Controller
{

    protected $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }


     public function register(Request $request)
     {

        try {

        $validatedData = $request->validate(
            [
                "name" => ["required", "string", "max:255"],
                "email" => ["required", "string", "email", "max:255", "unique:users"],
                "password" => ["required", "string", "min:8", "max:20"],
                "role" => ["required", "string", "in:user,project manager"]
            ]
        );

        $user = User::create([
            "name" => $validatedData["name"],
            "email" => $validatedData["email"],
            "password" => Hash::make($validatedData["password"]),
            "role" => $validatedData["role"]
        ]);


        $token = $this->tokenRepository->createToken("email_verification", $user->id);

        $url = "http://localhost:8000/api/auth/verify-email?token=$token";

        $emailContent = "Please click the following link to verify your email address: $url";

        Mail::raw($emailContent, function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Action Required: Verify Your Email Address');
        });


        return response()->json([
            "success" => true,
            "message" => "Registration successful. Please check your email for further instructions"
        ]);

    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 400);

    }

 }



    public function verifyEmail(Request $request)
    {
        $token = $request->token;

        $tokenData = $this->tokenRepository->findToken("email_verification",$token);

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
