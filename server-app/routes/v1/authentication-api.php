<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login']);
});
