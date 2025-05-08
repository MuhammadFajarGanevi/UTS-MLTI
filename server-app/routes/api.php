<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::prefix('v1')->group(function () {
    $v1RoutePath = base_path('routes/v1');

    foreach (glob($v1RoutePath . '/*-api.php') as $routeFile) {
        require $routeFile;
    }
});
