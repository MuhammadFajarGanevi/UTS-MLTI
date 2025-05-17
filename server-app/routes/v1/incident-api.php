<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\IncidentController;


Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('incident', [IncidentController::class, 'getAll']);

        Route::post('incident/create', [IncidentController::class, 'create']);
        Route::get('incident/{id}', [IncidentController::class, 'getId']);
        Route::get('incident/category', [IncidentController::class, 'getCategory']);
        Route::put('incident/status/{id}', [IncidentController::class, 'updateStatus']);
        Route::put('incident/worker/{id}', [IncidentController::class, 'updateWorker']);
        Route::delete('incident/{id}', [IncidentController::class, 'delete']);
    });

// Route /Incident



