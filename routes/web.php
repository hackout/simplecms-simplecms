<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DictController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SystemController;
use App\Http\Controllers\Backend\ManagerController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\DictItemController;
use App\Http\Controllers\Backend\ManagerLogController;

Route::group(['prefix' => '/backend'], function () {
    Route::middleware("auth")->group(function () {
        load_routes('routes/backend');
        Route::get('/', [BackendController::class, 'index'])->name('backend.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('backend.logout');
        Route::group(['prefix' => '/profile'], function () {
            Route::get('/', [ProfileController::class, 'index'])->name('backend.dashboard.profile');
            Route::get('/email', [ProfileController::class, 'email'])->name('backend.dashboard.profile.email');
            Route::get('/password', [ProfileController::class, 'password'])->name('backend.dashboard.profile.password');
            Route::post('/', [ProfileController::class, 'update'])->name('backend.dashboard.profile_update');
            Route::post('/email', [ProfileController::class, 'emailUpdate'])->name('backend.dashboard.profile.email_update');
            Route::post('/password', [ProfileController::class, 'passwordUpdate'])->name('backend.dashboard.profile.password_update');
        });
        Route::group(['prefix' => '/system'], function () {
            Route::get('/', [SystemController::class, 'index'])->name('backend.system')->middleware('role:backend.system');
            Route::post('/save', [SystemController::class, 'save'])->name('backend.system_save')->middleware('role:backend.system_save');
            Route::get('/list', [SystemController::class, 'list'])->name('backend.system_config_list')->middleware('role:backend.system_config_list');
            Route::post('/', [SystemController::class, 'create'])->name('backend.system_config_create')->middleware('role:backend.system_config_create');
            Route::get('/cache', [SystemController::class, 'cache'])->name('backend.system_cache')->middleware('role:backend.system_cache');
            Route::post('/cache', [SystemController::class, 'cacheClear'])->name('backend.system_cache_clear')->middleware('role:backend.system_cache_clear');
            Route::put('/{slug}', [SystemController::class, 'update'])->name('backend.system_config_update')->middleware('role:backend.system_config_update')->where(['slug' => slug_regex()]);
            Route::delete('/{slug}', [SystemController::class, 'delete'])->name('backend.system_config_delete')->middleware('role:backend.system_config_delete')->where(['slug' => slug_regex()]);
            Route::group(['prefix' => '/dict'], function () {
                Route::get('/', [DictController::class, 'index'])->name('backend.dict')->middleware('role:backend.dict');
                Route::get('/list', [DictController::class, 'list'])->name('backend.dict_list')->middleware('role:backend.dict_list');
                Route::post('/', [DictController::class, 'create'])->name('backend.dict_create')->middleware('role:backend.dict_create');
                Route::put('/{id}', [DictController::class, 'update'])->name('backend.dict_update')->middleware('role:backend.dict_update')->where(['id' => id_regex()]);
                ;
                Route::delete('/{id}', [DictController::class, 'delete'])->name('backend.dict_delete')->middleware('role:backend.dict_delete')->where(['id' => id_regex()]);
                ;
                Route::group(['prefix' => '/item'], function () {
                    Route::get('/list', [DictItemController::class, 'list'])->name('backend.dict_item_list')->middleware('role:backend.dict_item_list');
                    Route::post('/', [DictItemController::class, 'create'])->name('backend.dict_item_create')->middleware('role:backend.dict_item_create');
                    Route::post('/{id}', [DictItemController::class, 'update'])->name('backend.dict_item_update')->middleware('role:backend.dict_item_update')->where(['id' => id_regex()]);
                    ;
                    Route::delete('/{id}', [DictItemController::class, 'delete'])->name('backend.dict_item_delete')->middleware('role:backend.dict_item_delete')->where(['id' => id_regex()]);
                    ;
                    ;
                });
            });
            Route::group(['prefix' => '/menu'], function () {
                Route::get('/', [MenuController::class, 'index'])->name('backend.menu')->middleware('role:backend.menu');
                Route::get('/list', [MenuController::class, 'list'])->name('backend.menu_list')->middleware('role:backend.menu_list');
                Route::post('/', [MenuController::class, 'create'])->name('backend.menu_create')->middleware('role:backend.menu_create');
                Route::put('/{id}', [MenuController::class, 'update'])->name('backend.menu_update')->middleware('role:backend.menu_update')->where(['id' => id_regex()]);
                ;
                Route::post('/quick', [MenuController::class, 'quick'])->name('backend.menu_quick')->middleware('role:backend.menu_quick');
                Route::post('/delete', [MenuController::class, 'batchDelete'])->name('backend.menu_batch_delete')->middleware('role:backend.menu_batch_delete');
                Route::delete('/{id}', [MenuController::class, 'delete'])->name('backend.menu_delete')->middleware('role:backend.menu_delete')->where(['id' => id_regex()]);
                ;
            });
        });
        Route::group(['prefix' => '/manager'], function () {
            Route::get('/', [ManagerController::class, 'index'])->name('backend.manager')->middleware('role:backend.manager');
            Route::get('/list', [ManagerController::class, 'list'])->name('backend.manager_list')->middleware('role:backend.manager_list');
            Route::post('/', [ManagerController::class, 'create'])->name('backend.manager_create')->middleware('role:backend.manager_create');
            Route::put('/{id}', [ManagerController::class, 'update'])->name('backend.manager_update')->middleware('role:backend.manager_update')->where(['id' => uuid_regex()]);
            Route::post('/{id}', [ManagerController::class, 'password'])->name('backend.manager_password')->middleware('role:backend.manager_password')->where(['id' => uuid_regex()]);
            Route::delete('/{id}', [ManagerController::class, 'delete'])->name('backend.manager_delete')->middleware('role:backend.manager_delete')->where(['id' => uuid_regex()]);
            Route::group(['prefix' => '/log'], function () {
                Route::get('/', [ManagerLogController::class, 'index'])->name('backend.manager_log')->middleware('role:backend.manager_log');
                Route::get('/list', [ManagerLogController::class, 'list'])->name('backend.manager_log_list')->middleware('role:backend.manager_log_list');
                Route::delete('/{id}', [ManagerLogController::class, 'delete'])->name('backend.manager_log_delete')->middleware('role:backend.manager_log_delete')->where(['id' => uuid_regex()]);
                Route::post('/clean', [ManagerLogController::class, 'clean'])->name('backend.manager_log_clean')->middleware('role:backend.manager_log_clean');
            });
        });
        Route::group(['prefix' => '/role'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('backend.role')->middleware('role:backend.role');
            Route::get('/list', [RoleController::class, 'list'])->name('backend.role_list')->middleware('role:backend.role_list');
            Route::post('/', [RoleController::class, 'create'])->name('backend.role_create')->middleware('role:backend.role_create');
            Route::put('/{id}', [RoleController::class, 'update'])->name('backend.role_update')->middleware('role:backend.role_update')->where(['id' => id_regex()]);
            Route::delete('/{id}', [RoleController::class, 'delete'])->name('backend.role_delete')->middleware('role:backend.role_delete')->where(['id' => id_regex()]);

        });
    });
    Route::middleware("guest")->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('backend.login');
        Route::post('/login', [AuthController::class, 'auth'])->name('backend.login.auth');
        Route::get('/forget', [AuthController::class, 'forget'])->name('backend.forget');
        Route::post('/forget', [AuthController::class, 'sentResetLink'])->name('backend.forget.email');
        Route::get('/reset/{code}', [AuthController::class, 'reset'])->name('backend.reset')->where(['code' => uuid_regex()]);
        Route::post('/reset/{code}', [AuthController::class, 'resetPassword'])->name('backend.reset.password')->where(['code' => uuid_regex()]);
    });
    Route::get('/verify/{code}', [AuthController::class, 'verifyEmail'])->name('backend.verify.email')->where(['code' => uuid_regex()]);
});