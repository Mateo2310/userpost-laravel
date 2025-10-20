<?php

use Illuminate\Support\Facades\Route;

// Ruta básica para evitar 404 - redirige a API
Route::get('/', function () {
    return redirect('/api');
});
