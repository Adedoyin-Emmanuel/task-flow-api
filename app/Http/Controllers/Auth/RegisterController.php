<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{


     protected function register(Request $request)
     {

        $validatedData = $request->validate(
            [
                "name" => ["required", "string", "max:255"],
                "email" => ["required", "string", "email", "max:255", "unique:users"],
                "password" => ["required", "string", "min:8", "max:20", "confirmed"],
                "role" => ["required", "string", "in:user,project manager"]
            ]
        );


        try {
        // $user = User::create([
        //     'name' => $validatedData['name'],
        //     'email' => $validatedData['email'],
        //     'password' => Hash::make($validatedData['password']),
        //     'role' => $validatedData['role'],
        // ]);


        return response()->json([
                "success" => true,
                "message" => "Registration successful. Please check your email for further instructions"
        ]);

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Registration failed, please try again later.']);
    }

     }




}
