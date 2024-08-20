<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;



Route::get("/", function() {
    return response()->json([
        "success" => true,
        "message" => "Welcome to Task Flow API"
    ]);
});


Route::group(['prefix' => 'auth'], function () {

    Route::post('register', [RegisterController::class, 'register']);
    Route::get("/verify-email", [VerifyEmailController::class, 'verify']);
    Route::post('/login', [LoginController::class, 'login']);

});
