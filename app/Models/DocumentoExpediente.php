<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoExpediente extends Model
{
    protected $fillable = [
        'expediente_id', 'nombre_documento', 'clave_formato', 
        'estado', 'archivo_path', 'observaciones'
    ];

    public function expediente() 
    { 
        return $this->belongsTo(Expediente::class); 
    }
}