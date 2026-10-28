<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'sector', 'titular_nombre', 'titular_puesto', 
        'telefono', 'direccion', 'aplica_para', 'activa',
        'fecha_firma_convenio', 'fecha_inicio', 'fecha_termino', 
        'tipo_convenio_institucional', 'giro', 'tamano', 'actividad'
    ];
}