<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = ['nombre_completo', 'email', 'activo'];
}