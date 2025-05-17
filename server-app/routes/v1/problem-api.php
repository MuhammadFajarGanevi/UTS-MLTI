<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProblemController;


Route::middleware('auth:sanctum')
    ->group(function () {
    });

// Route /Incident
Route::post('problem', [ProblemController::class, 'create']);
Route::get('problem', [ProblemController::class, 'get']);
Route::get('problem/{id}', [ProblemController::class, 'getId']);
Route::put('problem/{id}', [ProblemController::class, 'update']);
Route::delete('problem/{id}', [ProblemController::class, 'delete']);


