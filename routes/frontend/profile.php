<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ProfileController;

Route::group(['prefix' => '/profile'],function(){
    Route::get('/list',[ProfileController::class,'list'])->name('frontend.profile.list');
    Route::get('/{id}',[ProfileController::class,'detail'])->name('frontend.profile.detail')->where(['id'=>uuid_regex()]);
    Route::post('/',[ProfileController::class,'create'])->name('frontend.profile.create');
    Route::put('/{id}',[ProfileController::class,'update'])->name('frontend.profile.update')->where(['id'=>uuid_regex()]);
    Route::delete('/{id}',[ProfileController::class,'delete'])->name('frontend.profile.delete')->where(['id'=>uuid_regex()]);
});