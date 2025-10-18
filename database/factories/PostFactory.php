<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4), // Título aleatorio de 4 palabras
            'description' => $this->faker->paragraph(3), // Descripción de 3 párrafos
            'imageUrl' => $this->faker->imageUrl(640, 480, 'posts', true), // URL de imagen falsa
            'user_id' => \App\Models\User::factory(), // Crea un usuario o usa uno existente
        ];
    }
}
