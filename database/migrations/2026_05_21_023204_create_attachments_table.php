<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. [cite: 274]
     */
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            // Relación con la tabla posts: si se borra el post, se borran sus archivos [cite: 277]
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); 
            
            $table->string('filename');      // Nombre único generado para el servidor [cite: 278]
            $table->string('original_name'); // Nombre real que tenía el archivo al subirlo [cite: 279]
            $table->string('mime_type');     // Ejemplo: image/png o application/pdf [cite: 280]
            $table->bigInteger('size');      // Tamaño en bytes [cite: 281]
            $table->string('path');          // Ruta física del archivo en el storage [cite: 282]
            
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};