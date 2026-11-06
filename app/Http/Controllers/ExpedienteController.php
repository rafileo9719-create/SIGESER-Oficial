<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Dependencia;
use App\Models\Alumno;
use App\Models\DocumentoExpediente; // <-- Importamos el modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpedienteController extends Controller
{
    public function index(Request $request)
    {
        // Si es alumno, lo mandamos directo a su expediente
        if (Auth::user()->rol === 'alumno') {
            // Buscamos al alumno por su correo institucional (o como lo vinculemos después)
            // Por ahora, como prueba, lo mandaremos al expediente 1
            return redirect()->route('expedientes.show', 1); 
        }

        // Si es Admin, ve la lista completa con búsqueda
        $query = Expediente::with(['alumno', 'dependencia']);
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
            'numero_afiliacion_imss' => 'required_if:proceso,RP|nullable|digits:11',
            'asesor_interno' => 'required_if:proceso,RP|nullable|string',
            ]);

        // Buscamos al alumno para obtener su ID
        $alumno = Alumno::where('matricula', $request->matricula)->first();

        // Creamos el expediente y lo guardamos en la variable $expediente
        $expediente = Expediente::create([
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

        // --- INICIO: Autogenerar los documentos ---
        $documentosSS = [
            'Solicitud de Servicio Social', 'Carta Compromiso', 
            'Carta de Presentación', 'Plan de Trabajo', 'Boleta de Actividades', 
            'Reporte Bimestral 1', 'Evaluación Cualitativa 1', 'Autoevaluación 1', 'Evaluación Actividades 1',
            'Reporte Bimestral 2', 'Evaluación Cualitativa 2', 'Autoevaluación 2', 'Evaluación Actividades 2',
            'Reporte Bimestral 3', 'Evaluación Cualitativa 3', 'Autoevaluación 3', 'Evaluación Actividades 3',
            'Reporte Final', 'Evaluación Cualitativa Final', 'Autoevaluación Final', 'Evaluación Actividades Final',
            'Carta de Terminación', 'Constancia de Terminación'
        ];

        $documentosRP = [
            'Portada Anteproyecto', 'Solicitud', 'Carta Responsiva', 'Kardex', 
            'Liberación SS', 'Liberación Inglés', 'Comprobante Reinscripción', 
            'Comprobante Seguro', 'Vigencia Derechos', 'Carta de Presentación',
            'Carta Aceptación', 'Cronograma 1', 'Bitácora 1', 'Evaluación Seguimiento 1',
            'Cronograma 2', 'Bitácora 2', 'Evaluación Seguimiento 2',
            'Cronograma 3', 'Bitácora 3', 'Evaluación Final', 'Proyecto Final', 'Carta Término'
        ];

        // Seleccionamos la lista según el proceso
        $lista = ($request->proceso === 'SS') ? $documentosSS : $documentosRP;

        // Documentos que el Encargado genera (El alumno NO los sube)
        $docsAdmin = ['Carta de Presentación', 'Constancia de Terminación'];

        foreach ($lista as $nombreDoc) {
            DocumentoExpediente::create([
                'expediente_id' => $expediente->id,
                'nombre_documento' => $nombreDoc,
                'estado' => 'Pendiente',
                'genera_admin' => in_array($nombreDoc, $docsAdmin) // Verifica si está en la lista del admin
            ]);
        }
        // --- FIN: Autogenerar documentos ---

        return redirect()->route('expedientes.index')->with('success', 'Expediente registrado y documentos generados exitosamente.');
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

    public function updateEstado(Request $request, DocumentoExpediente $documento)
    {
        $request->validate([
            'estado' => 'required|in:Aprobado,Rechazado,Pendiente',
            'observaciones' => 'nullable|string|max:500'
        ]);

        // Si no mandan observaciones desde el botón de aprobar, conservamos la que ya tenía
        $observaciones = $request->has('observaciones') ? $request->observaciones : $documento->observaciones;

        $documento->update([
            'estado' => $request->estado,
            'observaciones' => $observaciones
        ]);

        return redirect()->back()->with('success', 'Estado del documento actualizado correctamente.');
    }

    public function subirArchivo(Request $request, DocumentoExpediente $documento)
    {
        // Validamos que sea un archivo PDF o Imagen y que no pese más de 5MB
        $request->validate([
            'archivo' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('archivo')) {
            // Guardamos el archivo en la carpeta storage/app/public/documentos
            $path = $request->file('archivo')->store('documentos', 'public');
            
            // Actualizamos el documento
            $documento->update([
                'archivo_path' => $path,
                'estado' => 'Entregado' // Cambia automáticamente a Entregado
            ]);
        }

        return redirect()->back()->with('success', 'Archivo subido correctamente. En espera de revisión.');
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