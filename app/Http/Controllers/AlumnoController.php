<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function buscar(string $matricula)
    {
        $alumno = Alumno::where('matricula', trim($matricula))->first();

        if (!$alumno) {
            return response()->json(['encontrado' => false, 'message' => 'Matrícula no encontrada'], 404);
        }

        return response()->json([
            'encontrado' => true,
            'nombre' => "{$alumno->nombre} {$alumno->ap_paterno} {$alumno->ap_materno}",
            'carrera' => $alumno->carrera,
            'semestre' => $alumno->semestre,
            'correo' => $alumno->correo_institucional,
            'telefono' => $alumno->telefono,
        ]);
    }
}