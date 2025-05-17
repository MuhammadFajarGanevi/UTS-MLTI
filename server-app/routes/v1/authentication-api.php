<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::get('start', [AuthenticationController::class, 'start']);

    Route::middleware('auth:sanctum')
        ->group(function () {
            Route::post('refresh-token', [AuthenticationController::class, 'refreshToken']);
            Route::get('logout', [AuthenticationController::class, 'logout']);
            Route::get('user', [AuthenticationController::class, 'getUser']);
            Route::post('reset-password', [AuthenticationController::class, 'resetPassword']);
        });
});
