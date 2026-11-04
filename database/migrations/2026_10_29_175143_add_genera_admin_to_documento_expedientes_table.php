<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('documento_expedientes', function (Blueprint $table) {
        // Por defecto es false (el alumno sube el archivo)
        // Si es true, el admin lo genera.
        $table->boolean('genera_admin')->default(false); 
    });
}

public function down(): void
{
    Schema::table('documento_expedientes', function (Blueprint $table) {
        $table->dropColumn('genera_admin');
    });
}
};
