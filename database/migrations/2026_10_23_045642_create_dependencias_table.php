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
        Schema::create('dependencias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej. "Ayuntamiento de Tepeaca"
            $table->string('sector')->nullable(); // Ej. "Público", "Privado"
            $table->string('titular_nombre')->nullable();
            $table->string('titular_puesto')->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            // Aquí guardamos si el convenio es para SS, RP o Ambos
            $table->enum('tipo_convenio', ['SS', 'RP', 'AMBOS'])->default('AMBOS'); 
            $table->boolean('activa')->default(true); // Para desactivar sin borrar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependencias');
    }
};
