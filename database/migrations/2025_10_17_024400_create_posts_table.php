<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Campo id (auto-incremental)
            $table->string('title'); // Título del post
            $table->text('description'); // Descripción del post (texto largo)
            $table->string('imageUrl')->nullable(); // URL de la imagen (opcional)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Clave foránea a users
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
