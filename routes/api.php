<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Project\ProjectController;

Route::get("/", function () {
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



Route::group(['prefix' => 'project', 'middleware' => ['auth']], function () {
    Route::post('/', [ProjectController::class, 'create'])->middleware('role:admin');
    Route::get('/', [ProjectController::class, 'getAll']);
    Route::get('/{id}', [ProjectController::class, 'getById']);
    Route::put('/{id}', [ProjectController::class, 'update'])->middleware('role:admin,project manager');
    Route::delete('/{id}', [ProjectController::class, 'delete'])->middleware('role:admin');
});



