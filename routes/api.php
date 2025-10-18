<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas públicas (no requieren autenticación)
Route::get('/posts', [PostController::class, 'index']); // Listar todos los posts
Route::get('/posts/{id}', [PostController::class, 'show']); // Ver un post específico

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/posts', [PostController::class, 'store']); // Crear post
    Route::put('/posts/{id}', [PostController::class, 'update']); // Actualizar post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); // Eliminar post
});

// Ruta simple para demostrar la funcionalidad básica (SIN autenticación)
Route::post('/demo/posts', function () {
    $post = \App\Models\Post::create([
        'title' => 'Post desde API',
        'description' => 'Este post fue creado usando la API de Laravel',
        'imageUrl' => 'https://picsum.photos/800/600?random=' . rand(1, 100),
        'user_id' => 1, // Usuario admin
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Post creado exitosamente',
        'data' => $post
    ]);
});
