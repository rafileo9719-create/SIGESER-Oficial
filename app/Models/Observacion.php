<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
     // Forzamos el nombre de la tabla en español
    protected $table = 'observaciones';

    protected $fillable = ['expediente_id', 'user_id', 'comentario', 'estatus', 'documento_afectado'];
    // Relación: Una observación pertenece a un usuario (el que la escribió)
    public function user()
    {
       return $this->belongsTo(User::class);
    }
}