<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Dependencia;
use App\Models\Alumno;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Expediente::with(['alumno', 'dependencia']);

        // Lógica de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('alumno', function ($q) use ($buscar) {
                $q->where('matricula', 'like', "%{$buscar}%")
                  ->orWhere('nombre', 'like', "%{$buscar}%");
            });
        }

        $expedientes = $query->latest()->get();
        return view('expedientes.index', compact('expedientes'));
    }

    public function create()
    {
        $dependencias = Dependencia::where('activa', true)->get();
        return view('expedientes.create', compact('dependencias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricula' => 'required|exists:alumnos,matricula',
            'proceso' => 'required|in:SS,RP',
            'dependencia_id' => 'required|exists:dependencias,id',
            'periodo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Buscamos al alumno para obtener su ID
        $alumno = Alumno::where('matricula', $request->matricula)->first();

        // Creamos el expediente
        Expediente::create([
            'alumno_id' => $alumno->id,
            'dependencia_id' => $request->dependencia_id,
            'proceso' => $request->proceso,
            'periodo' => $request->periodo,
            'nombre_programa_proyecto' => $request->nombre_programa_proyecto,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'tipo_programa_ss' => $request->tipo_programa_ss,
            'modalidad_ss' => $request->modalidad_ss,
            'numero_afiliacion_imss' => $request->numero_afiliacion_imss,
            'asesor_interno' => $request->asesor_interno,
        ]);
        return redirect()->route('expedientes.index')->with('success', 'Expediente registrado exitosamente.');
    }

       public function show(Expediente $expediente)
    {
        // Cargamos el expediente con su alumno, su dependencia y todos sus documentos
        $expediente->load(['alumno', 'dependencia', 'documentos']);
        
        // Calculamos el progreso
        $totalDocs = $expediente->documentos->count();
        $docsAprobados = $expediente->documentos->where('estado', 'Aprobado')->count();
        $progreso = $totalDocs > 0 ? round(($docsAprobados / $totalDocs) * 100) : 0;

        return view('expedientes.show', compact('expediente', 'progreso', 'totalDocs', 'docsAprobados'));
    }
        public function updateEstado(Request $request, \App\Models\DocumentoExpediente $documento)
    {
        // Validamos que el estado sea uno de los permitidos
        $request->validate([
            'estado' => 'required|in:Aprobado,Rechazado,Pendiente',
            'observaciones' => 'nullable|string|max:500'
        ]);

        $documento->update([
            'estado' => $request->estado,
            'observaciones' => $request->observaciones
        ]);

        return redirect()->back()->with('success', 'Estado del documento actualizado correctamente.');
    }
    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
