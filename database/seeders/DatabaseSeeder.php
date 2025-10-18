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
        foreach (RoleEnum::cases() as $role) {
            \App\Models\Role::create(['name' => $role->value]);
        }

        if (!User::where('username', env('ADMIN_USERNAME', 'admin'))->exists()) {
        $admin = User::create([
            'username' => env('ADMIN_USERNAME', 'admin'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
        ]);

        $adminRole = Role::where('name', RoleEnum::ADMIN->value)->first();
        $admin->roles()->attach($adminRole);
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
