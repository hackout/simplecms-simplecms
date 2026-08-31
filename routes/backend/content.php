<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ArticleController;

Route::get('/', [ArticleController::class, 'index'])->name('backend.content.index')->middleware('role:backend.content.index');
Route::get('/review', [ArticleController::class, 'reviewPage'])->name('backend.content.review.page')->middleware('role:backend.content.review.page');
Route::get('/list', [ArticleController::class, 'list'])->name('backend.content.list')->middleware('role:backend.content.list');

Route::get('/category/list', [ArticleController::class, 'categoryList'])->name('backend.content.category.list')->middleware('role:backend.content.category.list');
Route::post('/category', [ArticleController::class, 'categoryCreate'])->name('backend.content.category.create')->middleware('role:backend.content.category.create');
Route::put('/category/{id}', [ArticleController::class, 'categoryUpdate'])->name('backend.content.category.update')->middleware('role:backend.content.category.update')->where(['id' => uuid_regex()]);
Route::delete('/category/{id}', [ArticleController::class, 'categoryDelete'])->name('backend.content.category.delete')->middleware('role:backend.content.category.delete')->where(['id' => uuid_regex()]);

Route::get('/tag/list', [ArticleController::class, 'tagList'])->name('backend.content.tag.list')->middleware('role:backend.content.tag.list');
Route::post('/tag', [ArticleController::class, 'tagCreate'])->name('backend.content.tag.create')->middleware('role:backend.content.tag.create');
Route::put('/tag/{id}', [ArticleController::class, 'tagUpdate'])->name('backend.content.tag.update')->middleware('role:backend.content.tag.update')->where(['id' => uuid_regex()]);
Route::delete('/tag/{id}', [ArticleController::class, 'tagDelete'])->name('backend.content.tag.delete')->middleware('role:backend.content.tag.delete')->where(['id' => uuid_regex()]);

Route::post('/', [ArticleController::class, 'create'])->name('backend.content.create')->middleware('role:backend.content.create');
Route::post('/{id}/review', [ArticleController::class, 'review'])->name('backend.content.review')->middleware('role:backend.content.review')->where(['id' => uuid_regex()]);
Route::post('/{id}/reject', [ArticleController::class, 'reject'])->name('backend.content.reject')->middleware('role:backend.content.reject')->where(['id' => uuid_regex()]);
Route::post('/{id}/publish', [ArticleController::class, 'publish'])->name('backend.content.publish')->middleware('role:backend.content.publish')->where(['id' => uuid_regex()]);
Route::get('/{id}/versions', [ArticleController::class, 'versions'])->name('backend.content.versions')->middleware('role:backend.content.versions')->where(['id' => uuid_regex()]);
Route::post('/{id}/restore-version', [ArticleController::class, 'restoreVersion'])->name('backend.content.restore-version')->middleware('role:backend.content.restore-version')->where(['id' => uuid_regex()]);
Route::put('/{id}', [ArticleController::class, 'update'])->name('backend.content.update')->middleware('role:backend.content.update')->where(['id' => uuid_regex()]);
Route::delete('/{id}', [ArticleController::class, 'delete'])->name('backend.content.delete')->middleware('role:backend.content.delete')->where(['id' => uuid_regex()]);
