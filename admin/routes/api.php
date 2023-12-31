<?php

use App\Http\Controllers\data\AccountTitleController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\system\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

# 公共路由
Route::group([
    'prefix' => 'public'
], function () {
    Route::post('upload_avatar', [PublicController::class, 'uploadAvatar']);
});


/**
 * 授权管理
 */
Route::middleware(['api'])->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/auth/info', [AuthController::class, 'info']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

/**
 * 需要登录的api
 */
Route::middleware('auth:api')->group(function () {
    /**
     * 系统管理
     */
    Route::prefix("system")->group(function () {
        Route::get('/user/info', [UserController::class, 'info']);
        Route::post('/user/reset_password', [UserController::class, 'resetPassword']);
        Route::apiResource('user', UserController::class);
    });

    /**
     * 财务资料
     */
    Route::prefix('data')->group(function () {
        # 会计科目相关路由
        Route::get('/account_title/page_config', [AccountTitleController::class, 'pageConfig']);
        Route::apiResource('account_title', AccountTitleController::class);
    });

});

