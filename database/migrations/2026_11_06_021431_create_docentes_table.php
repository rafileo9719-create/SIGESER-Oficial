<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ap_paterno');
            $table->string('ap_materno')->nullable();
            $table->string('grado_estudios')->nullable(); // Ej. MAESTRIA
            $table->string('escuela_egreso')->nullable();
            $table->string('cedula_profesional')->nullable();
            $table->string('puesto')->nullable();
            $table->string('carrera')->nullable(); // A qué carrera pertenece
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
