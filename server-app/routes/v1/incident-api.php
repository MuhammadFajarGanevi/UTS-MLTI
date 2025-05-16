<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\IncidentController;


Route::middleware('auth:sanctum')
    ->group(function () {
    });

// Route /Incident
Route::post('incident', [IncidentController::class, 'create']);
Route::get('incident', [IncidentController::class, 'get']);
Route::get('incident/{id}', [IncidentController::class, 'getId']);
Route::put('incident/{id}', [IncidentController::class, 'update']);
Route::delete('incident/{id}', [IncidentController::class, 'delete']);


