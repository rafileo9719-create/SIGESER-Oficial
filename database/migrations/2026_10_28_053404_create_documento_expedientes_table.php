<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documento_expedientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expediente_id')->constrained('expedientes')->onDelete('cascade');
            $table->string('nombre_documento');
            $table->string('clave_formato')->nullable();
            $table->string('estado')->default('Pendiente'); // Pendiente, Entregado, Aprobado, Rechazado
            $table->string('archivo_path')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documento_expedientes');
    }
};