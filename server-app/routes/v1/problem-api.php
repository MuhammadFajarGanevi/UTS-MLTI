<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProblemController;


Route::middleware('auth:sanctum')
    ->group(function () {

        Route::put('problem/status/{id}', [ProblemController::class, 'updateStatus']);
        Route::put('problem/worker/{id}', [ProblemController::class, 'updateWorker']);
        Route::get('problem/category', [ProblemController::class, 'getCategory']);
        // Route /problem
        Route::post('problem', [ProblemController::class, 'create']);
        Route::get('problem', [ProblemController::class, 'get']);
        Route::get('problem/{id}', [ProblemController::class, 'getId']);
        Route::delete('problem/{id}', [ProblemController::class, 'delete']);
    });



