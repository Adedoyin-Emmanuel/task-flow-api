<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Repositories\TokenRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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


        Log::debug($user->id);


        $token = $this->tokenRepository->createToken("email_verification", $user->id);
        $url = "http://localhost:8000/api/auth/verify-email" . $token;

        $emailContent = "Please click the following link to verify your email address: " . $url;

        Mail::raw($emailContent, function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Action Required: Verify Your Email Address');
        });


        return response()->json([
            "success" => true,
            "message" => "Registration successful. Please check your email for further instructions"
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 400);

    }

 }




}
