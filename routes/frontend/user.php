<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\UserController;

Route::group(['prefix' => '/user'],function(){
    Route::get('/list',[UserController::class,'list'])->name('frontend.user.list');
    Route::get('/{id}',[UserController::class,'detail'])->name('frontend.user.detail')->where(['id'=>uuid_regex()]);
    Route::post('/',[UserController::class,'create'])->name('frontend.user.create');
    Route::put('/{id}',[UserController::class,'update'])->name('frontend.user.update')->where(['id'=>uuid_regex()]);
    Route::delete('/{id}',[UserController::class,'delete'])->name('frontend.user.delete')->where(['id'=>uuid_regex()]);
});