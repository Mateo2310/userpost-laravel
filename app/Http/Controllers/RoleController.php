<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        
        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rol creado exitosamente',
            'data' => $role
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::with('users')->find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        $request->validate([
            'name' => ['string', 'max:255', Rule::unique('roles')->ignore($role->id)]
        ]);

        $role->update($request->only(['name', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado exitosamente',
            'data' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        // Verificar si hay usuarios con este rol
        if ($role->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el rol porque tiene usuarios asignados'
            ], 400);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rol eliminado exitosamente'
        ]);
    }
}