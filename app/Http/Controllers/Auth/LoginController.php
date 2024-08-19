<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{


    public function login(Request $request){

        try{

        $validatedData = $request->validate(
            [
                "email" => ["required", "string", "email", "max:255", "unique:users"],
                "password" => ["required", "string", "min:8", "max:20"],
            ]
        );


        return response()->json([
            "success" => true,
            "message" => "Login successful."
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 400);

    }
  }
}
