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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            
            // Usamos user_name para guardar el nombre directamente (como pide tu error)
            $table->string('user_name')->nullable(); 
            
            // Campos para el polimorfismo manual (model_type y model_id)
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            
            // Acción realizada (created, updated, deleted)
            $table->string('action'); 

            // Registros de cambios en formato JSON
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            // Datos de rastreo
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};