<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observaciones', function (Blueprint $table) {
            $table->id();
            // ¿A qué expediente pertenece esta observación?
            $table->foreignId('expediente_id')->constrained('expedientes')->onDelete('cascade');
            // ¿Quién hizo la observación? (El encargado)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->text('comentario'); // El texto de la observación
            $table->string('estatus')->default('Pendiente'); // Ej: Pendiente, Revisado, Rechazado
            $table->string('documento_afectado')->nullable(); // Opcional: Qué documento se observó (Ej. "F-RP-06")
            
            $table->timestamps(); // created_at (fecha de modificación) y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observacions');
    }
};
