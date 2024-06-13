<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserGroupController;

Route::group(['prefix' => '/user_group'], function () {
    Route::get('/', [UserGroupController::class, 'index'])->name('backend.user_group.index');
    Route::get('/list', [UserGroupController::class, 'list'])->name('backend.user_group.list');
    Route::post('/', [UserGroupController::class, 'create'])->name('backend.user_group.create');
    Route::put('/{id}', [UserGroupController::class, 'update'])->name('backend.user_group.update')->where(['id' => id_regex()]);
    Route::delete('/{id}', [UserGroupController::class, 'delete'])->name('backend.user_group.delete')->where(['id' => id_regex()]);
});