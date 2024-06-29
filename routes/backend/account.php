<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AccountController;

Route::get('/', [AccountController::class, 'index'])->name('backend.account.index');
Route::get('/list', [AccountController::class, 'list'])->name('backend.account.list');
Route::put('/{id}/{type}', [AccountController::class, 'update'])->name('backend.account.update')->where(['id' => uuid_regex(),'type'=>id_regex()]);
Route::delete('/{id}/{type}', [AccountController::class, 'delete'])->name('backend.account.delete')->where(['id' => uuid_regex(),'type'=>id_regex()]);