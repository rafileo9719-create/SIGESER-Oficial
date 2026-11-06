@extends('adminlte::page')

@section('title', 'Detalle del Expediente')

@section('content_header')
    <h1>Detalle del Expediente</h1>
@stop

@section('content')
    
    <!-- 1. DATOS DEL ALUMNO -->
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-graduate"></i> Datos del Estudiante</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <strong>Nombre:</strong> {{ $expediente->alumno->nombre }} <br>
                            <strong>Matrícula:</strong> {{ $expediente->alumno->matricula }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>Carrera:</strong> {{ $expediente->alumno->carrera }} <br>
                            <strong>Semestre:</strong> {{ $expediente->alumno->semestre }}° Semestre
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>Proceso:</strong> {{ $expediente->proceso == 'SS' ? 'Servicio Social' : 'Residencia' }} <br>
                            <strong>Periodo:</strong> {{ $expediente->periodo }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Dependencia:</strong> {{ $expediente->dependencia->nombre }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CHECKLIST DE DOCUMENTOS -->
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list-check"></i> Lista de Documentos y Entregas</h3>
                </div>
                <div class="card-body">
                    
                    <!-- Barra de Progreso -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="m-0"><strong>Progreso del Expediente</strong></h4>
                            <h4 class="m-0 text-success"><strong>{{ $progreso }}%</strong> ({{ $docsAprobados }} de {{ $totalDocs }})</h4>
                        </div>
                        <div class="progress mt-2" style="height: 20px;">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $progreso }}%" aria-valuenow="{{ $progreso }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Tabla de Documentos -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 20%;">Documento</th>
                                    <th class="text-center" style="width: 30%;">Estado y Observaciones</th>
                                    <th class="text-center" style="width: 50%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expediente->documentos as $doc)
                                <tr>
                                    <td class="align-middle font-weight-bold">{{ $doc->nombre_documento }}</td>
                                    
                                <!-- COLUMNA ESTADO Y OBSERVACIONES -->
                                    <td class="text-center align-middle">
                                        @if($doc->estado == 'Pendiente')
                                            <span class="badge text-bg-warning px-3 py-2">Pendiente</span>
                                        @elseif($doc->estado == 'Entregado')
                                            <span class="badge text-bg-info px-3 py-2">Entregado</span>
                                        @elseif($doc->estado == 'Aprobado')
                                            <span class="badge text-bg-success px-3 py-2"><i class="fas fa-check-circle"></i> Aprobado</span>
                                        @else
                                            <span class="badge text-bg-danger px-3 py-2"><i class="fas fa-times-circle"></i> Rechazado</span>
                                        @endif
                                        
                                        @if($doc->observaciones)
                                            <div class="mt-2 alert alert-warning py-1 px-2 text-left" style="font-size: 0.85rem; margin-bottom: 0;">
                                                <strong><i class="fas fa-comment-dots"></i> Observación:</strong> <br>
                                                {{ $doc->observaciones }}
                                            </div>
                                        @endif
                                    </td>
                                                                    <!-- COLUMNA ACCIONES -->
                                    <td class="text-center align-middle">
                                        <div class="d-flex flex-row flex-nowrap justify-content-center gap-1" style="min-width: 420px;">
                                            
                                            <!-- 1. BOTÓN GENERAR (Para todos) -->
                                            <button class="btn btn-sm btn-primary text-nowrap" title="Descargar Formato">
                                                <i class="fas fa-download"></i> Generar
                                            </button>
                                            
                                            <!-- 2. BOTÓN VER (Solo si ya hay archivo subido) -->
                                            @if($doc->archivo_path)
                                                <a href="{{ asset('storage/' . $doc->archivo_path) }}" target="_blank" class="btn btn-sm btn-dark text-nowrap" title="Ver Archivo">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            @endif
                                            
                                            <!-- 3. ACCIONES DEL ALUMNO -->
                                            @if(Auth::user()->rol === 'alumno' && !$doc->genera_admin)
                                                
                                                @if($doc->estado === 'Pendiente' || $doc->estado === 'Rechazado')
                                                    <!-- Puede subir si está pendiente o si se lo rechazaron -->
                                                    <button type="button" class="btn btn-sm btn-success text-nowrap btn-subir" 
                                                            data-id="{{ $doc->id }}" data-nombre="{{ $doc->nombre_documento }}"
                                                            data-bs-toggle="modal" data-bs-target="#modalSubirArchivo">
                                                        <i class="fas fa-upload"></i> Subir
                                                    </button>
                                                @elseif($doc->estado === 'Entregado')
                                                    <!-- Botón bloqueado mientras el admin lo revisa -->
                                                    <button class="btn btn-sm btn-secondary text-nowrap" disabled title="Esperando revisión del encargado">
                                                        <i class="fas fa-clock"></i> En Revisión
                                                    </button>
                                                @endif
                                            @endif

                                            <!-- 4. ACCIONES DEL ENCARGADO (ADMIN) -->
                                            @if(Auth::user()->rol === 'admin')
                                                
                                                <!-- Aprobar (Solo si no está aprobado y YA subió archivo) -->
                                                @if($doc->estado !== 'Aprobado' && $doc->archivo_path)
                                                    <form action="{{ route('documentos.updateEstado', $doc) }}" method="POST" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="estado" value="Aprobado">
                                                        <button type="submit" class="btn btn-sm btn-info text-nowrap" title="Aprobar Documento">
                                                            <i class="fas fa-check"></i> Aprobar
                                                        </button>
                                                    </form>
                                                @elseif($doc->estado === 'Aprobado')
                                                    <button class="btn btn-sm btn-success text-nowrap" disabled>
                                                        <i class="fas fa-check-circle"></i> Aprobado
                                                    </button>
                                                @endif

                                                <!-- Observar / Rechazar (Disponible siempre que el alumno haya subido algo) -->
                                                @if($doc->archivo_path)
                                                    <button type="button" class="btn btn-sm btn-danger text-nowrap btn-evaluar" 
                                                            data-id="{{ $doc->id }}" data-nombre="{{ $doc->nombre_documento }}" 
                                                            data-estado="{{ $doc->estado == 'Aprobado' ? 'Aprobado' : 'Rechazado' }}"
                                                            data-observaciones="{{ $doc->observaciones }}"
                                                            data-bs-toggle="modal" data-bs-target="#modalObservaciones">
                                                        @if($doc->observaciones)
                                                            <i class="fas fa-edit"></i> Editar Obs.
                                                        @else
                                                            <i class="fas fa-times"></i> Rechazar
                                                        @endif
                                                    </button>
                                                @endif
                                            @endif   
                                        </div>
                                    </td>
                             
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        No hay documentos asignados a este expediente.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA SUBIR ARCHIVO -->
    <div class="modal fade" id="modalSubirArchivo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formSubirArchivo" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Subir Documento Escaneado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="font-weight-bold text-primary" id="nombre-documento-subir"></h6>
                        <p class="text-muted text-sm">Selecciona el archivo PDF o Imagen (Máx. 5MB).</p>
                        
                        <div class="form-group mt-3">
                            <input class="form-control" type="file" name="archivo" required accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Subir Archivo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PARA OBSERVACIONES -->
    <div class="modal fade" id="modalObservaciones" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formObservaciones" method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar Observación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="font-weight-bold text-primary" id="nombre-documento-modal"></h6>
                        <input type="hidden" name="estado" id="estado-input">
                        
                        <div class="form-group mt-3">
                            <label for="observaciones">Escribe la observación para el alumno:</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" rows="4" placeholder="Ej. Falta la firma del titular..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Guardar Observación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    // Esperamos a que todo el HTML cargue
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- 1. Configurar Modal de Subida ---
        const modalSubir = document.getElementById('modalSubirArchivo');
        if (modalSubir) {
            modalSubir.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; 
                const id = button.getAttribute('data-id');
                const nombre = button.getAttribute('data-nombre');

                document.getElementById('nombre-documento-subir').textContent = 'Documento: ' + nombre;
                
                let url = "{{ route('documentos.subir', ':id') }}";
                url = url.replace(':id', id);
                document.getElementById('formSubirArchivo').setAttribute('action', url);
            });
        }

        // --- 2. Configurar Modal de Observaciones ---
        const modalObs = document.getElementById('modalObservaciones');
        if (modalObs) {
            modalObs.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; 
                const id = button.getAttribute('data-id');
                const nombre = button.getAttribute('data-nombre');
                const estado = button.getAttribute('data-estado');
                const observaciones = button.getAttribute('data-observaciones');

                document.getElementById('nombre-documento-modal').textContent = 'Documento: ' + nombre;
                document.getElementById('estado-input').value = estado;
                document.getElementById('observaciones').value = observaciones;
                
                let url = "{{ route('documentos.updateEstado', ':id') }}";
                url = url.replace(':id', id);
                document.getElementById('formObservaciones').setAttribute('action', url);
            });
        }

    });
</script>
@stop