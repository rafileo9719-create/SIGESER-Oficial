<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // <-- Esta línea faltaba

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos los 4 roles base de SIGESER
        Role::create(['name' => 'admin']);       // Control total
        Role::create(['name' => 'encargado']);   // Servicio Social
        Role::create(['name' => 'alumno']);      // Estudiantes
        Role::create(['name' => 'docente']);     // Asesores internos
    }
}