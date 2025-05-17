<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RequestServiceController;


Route::middleware('auth:sanctum')
    ->group(function () {
    });

// Route /Incident
Route::post('request-service', [RequestServiceController::class, 'create']);
Route::get('request-service', [RequestServiceController::class, 'get']);
Route::get('request-service/{id}', [RequestServiceController::class, 'getId']);
Route::put('request-service/{id}', [RequestServiceController::class, 'update']);
Route::delete('request-service/{id}', [RequestServiceController::class, 'delete']);


