<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\UserLogController;


Route::get('/', [UserController::class, 'index'])->name('backend.user.index');
Route::get('/list', [UserController::class, 'list'])->name('backend.user.list');
Route::get('/{id}', [UserController::class, 'detail'])->name('backend.user.detail')->where(['id' => uuid_regex()]);
Route::post('/{id}', [UserController::class, 'update'])->name('backend.user.update')->where(['id' => uuid_regex()]);
Route::put('/{id}/password', [UserController::class, 'password'])->name('backend.user.password')->where(['id' => uuid_regex()]);
Route::put('/{id}/profile', [UserController::class, 'profile'])->name('backend.user.profile')->where(['id' => uuid_regex()]);
Route::delete('/{id}', [UserController::class, 'delete'])->name('backend.user.delete')->where(['id' => uuid_regex()]);
Route::get('/{id}/list', [UserLogController::class, 'list'])->name('backend.user_log.list')->where(['id' => uuid_regex()]);
Route::delete('/{id}/{log_id}', [UserLogController::class, 'delete'])->name('backend.user_log.delete')->middleware('role:backend.user_log.delete')->where(['id' => uuid_regex(), 'log_id' => uuid_regex()]);
Route::post('/{id}/clean', [UserLogController::class, 'clean'])->name('backend.user_log.clean')->middleware('role:backend.user_log.clean');