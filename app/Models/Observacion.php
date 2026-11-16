<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    // Esta línea le dice a Laravel: "Oye, la tabla se llama en español"
    protected $table = 'observaciones';

    protected $fillable = ['expediente_id', 'user_id', 'comentario', 'estatus', 'documento_afectado'];
    // Relación: Una observación pertenece a un usuario (el que la escribió)
    public function user()
    {
       return $this->hasMany(Observacion::class)->latest();
    }
}