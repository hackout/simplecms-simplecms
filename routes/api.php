<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\PublicController;
use App\Http\Controllers\Frontend\WechatMiniController;

//游客
Route::middleware('guest')->group(function () {
    Route::post("/register", [AuthController::class, 'register']);
});
Route::group(['prefix' => '/public'], function () {
    Route::get('/init', [PublicController::class, 'init']);
});
Route::group(['prefix' => '/wechat'], function () {
    Route::group(['prefix' => '/mini'], function () {
        Route::post('/token/{code}', [WechatMiniController::class, 'token'])->where(['code' => slug_regex()]);
    });
});

//登录用户
Route::middleware('auth:sanctum')->group(function () {
    load_routes('routes/frontend');
});
