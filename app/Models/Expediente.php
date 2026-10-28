<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    protected $fillable = [
        'alumno_id', 'dependencia_id', 'proceso', 'periodo', 
        'nombre_programa_proyecto', 'fecha_inicio', 'fecha_fin', 
        'tipo_programa_ss', 'modalidad_ss', 'horas_acumuladas', 
        'numero_afiliacion_imss', 'asesor_interno', 'asesor_externo', 'observaciones'
    ];
     // Relaciones
    public function alumno() 
    { return $this->belongsTo(Alumno::class); }
    public function dependencia()
     { return $this->belongsTo(Dependencia::class); }
      public function documentos() 
    { return $this->hasMany(DocumentoExpediente::class); }
}