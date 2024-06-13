<?php

use App\Http\Controllers\Frontend\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//游客
Route::middleware('guest')->group(function () {
    Route::post("/register", [AuthController::class, 'register']);
});

//登录用户
Route::middleware('auth:sanctum')->group(function () {

});
