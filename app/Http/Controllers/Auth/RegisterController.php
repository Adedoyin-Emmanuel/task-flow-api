<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{


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
