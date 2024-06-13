<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AccountController;

Route::group(['prefix' => '/account'],function(){
    Route::get('/list',[AccountController::class,'list'])->name('frontend.account.list');
    Route::get('/{id}',[AccountController::class,'detail'])->name('frontend.account.detail')->where(['id'=>uuid_regex()]);
    Route::post('/',[AccountController::class,'create'])->name('frontend.account.create');
    Route::put('/{id}',[AccountController::class,'update'])->name('frontend.account.update')->where(['id'=>uuid_regex()]);
    Route::delete('/{id}',[AccountController::class,'delete'])->name('frontend.account.delete')->where(['id'=>uuid_regex()]);
});