<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Mostrar todos los posts (para la demo)
     */
    public function index()
    {
        // Obtener todos los posts con información del usuario
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Este método normalmente devolvería una vista de formulario
        // Para una API, no es necesario
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'imageUrl' => 'nullable|url',
        ]);

        // Crear el post asociado al usuario autenticado
        $post = Auth::user()->posts()->create($validatedData);

        return response()->json($post->load('user'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('user')->findOrFail($id);
        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Para una API, este método no es necesario
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        
        // Verificar que el usuario sea el propietario del post
        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'imageUrl' => 'nullable|url',
        ]);

        $post->update($validatedData);

        return response()->json($post->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        
        // Verificar que el usuario sea el propietario del post
        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post eliminado correctamente']);
    }
}
