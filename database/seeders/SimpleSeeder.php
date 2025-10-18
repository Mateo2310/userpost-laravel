<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Post;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SimpleSeeder extends Seeder
{
    /**
     * Seeder simple para la demo de entrevista
     */
    public function run(): void
    {
        // 1. Crear roles básicos
        Role::create(['name' => 'ADMIN']);
        Role::create(['name' => 'USER']);

        // 2. Crear usuario admin
        $admin = User::create([
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'role_id' => 1, // ADMIN
        ]);

        // 3. Crear usuario normal
        $user = User::create([
            'username' => 'john_doe',
            'password' => Hash::make('123456'),
            'role_id' => 2, // USER
        ]);

        // 4. Crear posts de ejemplo
        Post::create([
            'title' => 'Mi primer post',
            'description' => 'Este es el contenido de mi primer post en Laravel.',
            'imageUrl' => 'https://picsum.photos/800/600?random=1',
            'user_id' => $admin->id,
        ]);

        Post::create([
            'title' => 'Aprendiendo PHP',
            'description' => 'PHP es un lenguaje muy útil para desarrollo web backend.',
            'imageUrl' => 'https://picsum.photos/800/600?random=2',
            'user_id' => $user->id,
        ]);

        Post::create([
            'title' => 'Laravel Framework',
            'description' => 'Laravel hace que PHP sea más elegante y fácil de usar.',
            'imageUrl' => null, // Post sin imagen
            'user_id' => $user->id,
        ]);

        echo "✅ Datos de prueba creados exitosamente!\n";
        echo "👤 Usuario admin: admin / 123456\n";
        echo "👤 Usuario normal: john_doe / 123456\n";
        echo "📝 3 posts de ejemplo creados\n";
    }
}