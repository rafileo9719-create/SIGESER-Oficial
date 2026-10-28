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
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();

                // Relaciones principales
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('dependencia_id')->nullable()->constrained('dependencias')->onDelete('set null');
            
            // Datos del trámite
            $table->string('proceso'); // 'SS' para Servicio Social o 'RP' para Residencia
            $table->string('periodo'); // Ej. 'Junio-Diciembre 2026'
                // Datos del proyecto/programa
            $table->string('nombre_programa_proyecto')->nullable(); 
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            
            // Datos exclusivos de Servicio Social (SS)
            $table->string('tipo_programa_ss')->nullable(); 
            $table->string('modalidad_ss')->nullable(); 
            $table->integer('horas_acumuladas')->default(0);
            
            // Datos exclusivos de Residencia (RP)
            $table->string('numero_afiliacion_imss')->nullable();
            $table->string('asesor_interno')->nullable();
            $table->decimal('eval_1', 5, 2)->nullable();
            $table->decimal('eval_2', 5, 2)->nullable();
            $table->decimal('eval_final', 5, 2)->nullable();

            // Asesor Externo (común en ambos, sacado de la dependencia)
            $table->string('asesor_externo')->nullable(); 
            $table->string('observaciones')->nullable();
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};
