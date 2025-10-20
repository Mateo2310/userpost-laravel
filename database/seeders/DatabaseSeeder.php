<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Post;
use App\Enums\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles si no existen
        foreach (RoleEnum::cases() as $role) {
            if (!Role::where('name', $role->value)->exists()) {
                \App\Models\Role::create(['name' => $role->value]);
            }
        }

        $adminRole = Role::where('name', RoleEnum::ADMIN->value)->first();
        
        if (!User::where('username', env('ADMIN_USERNAME', 'admin'))->exists()) {
            $admin = User::create([
                'username' => env('ADMIN_USERNAME', 'admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
                'role_id' => $adminRole->id,
            ]);
        } else {
            $admin = User::where('username', env('ADMIN_USERNAME', 'admin'))->first();
        }

        // Crear algunos usuarios de ejemplo y posts
        $users = User::factory(5)->create(); // Crear 5 usuarios aleatorios
        
        // Crear posts para cada usuario
        foreach ($users as $user) {
            Post::factory(rand(1, 3))->create(['user_id' => $user->id]);
        }
        
        // Crear algunos posts para el admin también
        if ($admin) {
            Post::factory(2)->create(['user_id' => $admin->id]);
        }
    }
}
