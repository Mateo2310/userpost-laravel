<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Health check y ruta raíz
Route::get('/', function () {
    return response()->json([
        'message' => 'UserPost API',
        'version' => app()->version(),
        'status' => 'OK',
        'timestamp' => now()
    ]);
});

Route::get('/up', function () {
    return response()->json([
        'message' => 'UserPost API',
        'version' => app()->version(),
        'status' => 'OK',
        'timestamp' => now()
    ]);
});

// Rutas de autenticación
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('logout');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth:sanctum'])->group(function () {
    // Rutas para Posts
    Route::post('/posts', [PostController::class, 'store']); // Crear post
    Route::put('/posts/{id}', [PostController::class, 'update']); // Actualizar post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); // Eliminar post
    Route::get('/posts', [PostController::class, 'index']); // Listar todos los posts
    Route::get('/posts/{id}', [PostController::class, 'show']); // Ver un post específico
    
    // Rutas para Users
    Route::get('/users', [UserController::class, 'index']); // Listar todos los usuarios
    Route::post('/users', [UserController::class, 'store']); // Crear usuario
    Route::get('/users/{id}', [UserController::class, 'show']); // Ver un usuario específico
    Route::put('/users/{id}', [UserController::class, 'update']); // Actualizar usuario
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Eliminar usuario
    
    // Rutas para Roles
    Route::get('/roles', [RoleController::class, 'index']); // Listar todos los roles
    Route::post('/roles', [RoleController::class, 'store']); // Crear rol
    Route::get('/roles/{id}', [RoleController::class, 'show']); // Ver un rol específico
    Route::put('/roles/{id}', [RoleController::class, 'update']); // Actualizar rol
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']); // Eliminar rol
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
