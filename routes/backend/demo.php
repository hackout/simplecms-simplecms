<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DemoController;

Route::get('/', [DemoController::class, 'index'])->name('backend.demo.index');
Route::get('/crud', [DemoController::class, 'crud'])->name('backend.demo.crud');
Route::get('/detail', [DemoController::class, 'detail'])->name('backend.demo.detail');
Route::get('/form', [DemoController::class, 'form'])->name('backend.demo.form');
Route::get('/dashboard', [DemoController::class, 'dashboard'])->name('backend.demo.dashboard');
