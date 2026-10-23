<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'sector', 'titular_nombre', 'titular_puesto', 
        'telefono', 'direccion', 'tipo_convenio', 'activa'
    ];
}