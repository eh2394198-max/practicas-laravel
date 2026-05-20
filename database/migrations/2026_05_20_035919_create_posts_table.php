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
        $table->id();

        $table->string('name'); // Título del post
        $table->string('slug')->unique(); // URL amigable
        $table->text('extract')->nullable(); // Resumen (nullable por si no quieren ponerlo)
        $table->longText('body')->nullable(); // Contenido completo
        $table->enum('status', [1, 2])->default(1); // 1: Borrador, 2: Publicado

        // Llaves Foráneas (Relaciones)
        // Relación con Usuarios
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Relación con Categorías
        $table->foreignId('category_id')->constrained()->onDelete('cascade');

        $table->timestamps();
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
