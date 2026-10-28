<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula', 'nombre', 'ap_paterno', 'ap_materno', 
        'carrera', 'semestre', 'correo_institucional', 'telefono', 'status'
    ];

    // Aquí va la nueva función de relación
    public function expedientes() 
    { 
        return $this->hasMany(Expediente::class); 
    }
}