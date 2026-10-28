<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dependencias', function (Blueprint $table) {
            // Nuevos campos del Excel
            $table->date('fecha_firma_convenio')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->string('fecha_termino')->nullable(); // Puede ser 'INDEFINIDO'
            $table->string('tipo_convenio_institucional')->nullable(); // Alianzas, Académico, etc.
            $table->string('giro')->nullable(); // Educativo, Hotel...
            $table->string('tamano')->nullable(); // Grande, Mediana...
            $table->string('actividad')->nullable(); // Científica, Innovación...
            
            // Renombramos el campo anterior para que no haya confusión
            $table->renameColumn('tipo_convenio', 'aplica_para'); // Aquí pondremos SS, RP o AMBOS
        });
    }

    public function down(): void
    {
        Schema::table('dependencias', function (Blueprint $table) {
            $table->dropColumn([
                'fecha_firma_convenio', 'fecha_inicio', 'fecha_termino', 
                'tipo_convenio_institucional', 'giro', 'tamano', 'actividad'
            ]);
            $table->renameColumn('aplica_para', 'tipo_convenio');
        });
    }
};