<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RequestServiceController;


Route::middleware('auth:sanctum')
    ->group(function () {

        // Route /RequestService
        Route::put('request-service/worker/{id}', [RequestServiceController::class, 'updateWorker']);
        Route::put('request-service/status/{id}', [RequestServiceController::class, 'updateStatus']);
        Route::get('request-service/category', [RequestServiceController::class, 'getCategory']);


        Route::post('request-service', [RequestServiceController::class, 'create']);
        Route::get('request-service', [RequestServiceController::class, 'get']);
        Route::get('request-service/{id}', [RequestServiceController::class, 'getId']);
        Route::delete('request-service/{id}', [RequestServiceController::class, 'delete']);
    });




