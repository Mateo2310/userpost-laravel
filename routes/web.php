<?php

use Illuminate\Support\Facades\Route;

// Ruta básica de health check
Route::get('/', function () {
    return response()->json([
        'message' => 'UserPost API',
        'version' => app()->version(),
        'status' => 'OK'
    ]);
});
