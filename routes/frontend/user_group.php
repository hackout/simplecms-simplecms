<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\UserGroupController;

Route::group(['prefix' => '/user_group'],function(){
    Route::get('/list',[UserGroupController::class,'list'])->name('frontend.user_group.list');
    Route::get('/{id}',[UserGroupController::class,'detail'])->name('frontend.user_group.detail')->where(['id'=>uuid_regex()]);
    Route::post('/',[UserGroupController::class,'create'])->name('frontend.user_group.create');
    Route::put('/{id}',[UserGroupController::class,'update'])->name('frontend.user_group.update')->where(['id'=>uuid_regex()]);
    Route::delete('/{id}',[UserGroupController::class,'delete'])->name('frontend.user_group.delete')->where(['id'=>uuid_regex()]);
});