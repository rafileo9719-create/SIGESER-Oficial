@extends('adminlte::page')

@section('title', 'Detalle del Expediente')

@section('content_header')
    <h1>Detalle del Expediente</h1>
@stop

@section('content')
    
    <!-- MENSAJE DE ÉXITO -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- 1. DATOS DEL ALUMNO -->
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm">
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
                            <strong>Dependencia:</strong> {{ $expediente->dependencia->nombre ?? 'No asignada' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CHECKLIST DE DOCUMENTOS -->
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-success shadow-sm">
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
                                            
                                            <!-- 1. BOTÓN GENERAR -->
                                            <button class="btn btn-sm btn-primary text-nowrap" title="Descargar Formato">
                                                <i class="fas fa-download"></i> Generar
                                            </button>
                                            
                                            <!-- 2. BOTÓN VER -->
                                            @if($doc->archivo_path)
                                                <a href="{{ asset('storage/' . $doc->archivo_path) }}" target="_blank" class="btn btn-sm btn-dark text-nowrap" title="Ver Archivo">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            @endif
                                            
                                            <!-- 3. ACCIONES DEL ALUMNO -->
                                            @role('alumno')
                                                @if(!$doc->genera_admin)
                                                    @if($doc->estado === 'Pendiente' || $doc->estado === 'Rechazado')
                                                        <button type="button" class="btn btn-sm btn-success text-nowrap btn-subir" 
                                                                data-id="{{ $doc->id }}" data-nombre="{{ $doc->nombre_documento }}"
                                                                data-bs-toggle="modal" data-bs-target="#modalSubirArchivo">
                                                            <i class="fas fa-upload"></i> Subir
                                                        </button>
                                                    @elseif($doc->estado === 'Entregado')
                                                        <button class="btn btn-sm btn-secondary text-nowrap" disabled title="Esperando revisión">
                                                            <i class="fas fa-clock"></i> En Revisión
                                                        </button>
                                                    @endif
                                                @endif
                                            @endrole

                                            <!-- 4. ACCIONES DEL ENCARGADO / ADMIN -->
                                            @hasanyrole('admin|encargado')
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
                                            @endhasanyrole   
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No hay documentos asignados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. HISTORIAL DE OBSERVACIONES GENERALES (BITÁCORA) -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-history"></i> Bitácora de Observaciones del Expediente</h3>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                 
                    @forelse($expediente->bitacora ?? [] as $obs)
                        @php
                            // Colores de fondo
                            $bgColor = $obs->estatus == 'Revisado' ? '#d4edda' : ($obs->estatus == 'Rechazado' ? '#f8d7da' : '#fff3cd');
                            $borderColor = $obs->estatus == 'Revisado' ? '#28a745' : ($obs->estatus == 'Rechazado' ? '#dc3545' : '#ffc107');
                            
                            // Colores del badge de estatus
                            $badgeBg = $obs->estatus == 'Revisado' ? '#28a745' : ($obs->estatus == 'Rechazado' ? '#dc3545' : '#ffc107');
                            $badgeText = $obs->estatus == 'Pendiente' ? '#212529' : 'white';
                        @endphp
                        
                        <div class="p-3 mb-3 rounded shadow-sm" style="background-color: {{ $bgColor }}; border-left: 5px solid {{ $borderColor }};">
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="font-weight-bold m-0" style="color: #621132 !important;">
                                    <i class="fas fa-user-circle"></i> {{ $obs->user->name ?? 'Sistema' }}
                                </h6>
                                <small class="font-weight-bold" style="color: #212529 !important;">
                                    <i class="far fa-clock"></i> {{ $obs->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            
                            <p class="mb-3" style="color: #212529 !important; font-size: 1.05rem; font-weight: 500;">
                                {{ $obs->comentario }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-end">
                                <!-- Aquí recuperamos el nombre del documento con un fondo gris oscuro -->
                                @if($obs->documento_afectado)
                                    <span class="badge px-2 py-1 shadow-sm" style="background-color: #6c757d !important; color: white !important; font-size: 0.85rem;">
                                        <i class="fas fa-file-alt"></i> {{ $obs->documento_afectado }}
                                    </span>
                                @else
                                    <span></span>
                                @endif

                                <!-- Etiqueta del estatus -->
                                <span class="badge px-3 py-1 shadow-sm" style="background-color: {{ $badgeBg }} !important; color: {{ $badgeText }} !important; font-size: 0.85rem;">
                                    {{ $obs->estatus }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-check fa-3x mb-3" style="color: #6c757d !important;"></i>
                            <p style="color: #212529 !important;">No hay observaciones generales registradas aún.</p>
                        </div>
                    @endforelse
             
                    
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL PARA SUBIR ARCHIVO (ÚNICO)           -->
    <!-- ========================================== -->
    <div class="modal fade" id="modalSubirArchivo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form id="formSubirArchivo" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header text-white" style="background-color: #621132;">
                        <h5 class="modal-title font-weight-bold"><i class="fas fa-cloud-upload-alt mr-2"></i> Subir Documento</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-file-pdf fa-3x text-muted mb-2"></i>
                            <h5 class="font-weight-bold text-primary" id="nombre-documento-subir"></h5>
                            <p class="text-muted small">Asegúrate de que el archivo sea legible y contenga las firmas requeridas.</p>
                        </div>
                        
                        <div class="form-group">
                            <input type="file" class="form-control" name="archivo" required accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <small class="text-danger mt-1 d-block"><i class="fas fa-info-circle"></i> Tamaño máximo permitido: 5MB.</small>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn text-white font-weight-bold" style="background-color: #621132;">
                            <i class="fas fa-upload mr-1"></i> Subir Archivo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL PARA OBSERVACIONES (ÚNICO)           -->
    <!-- ========================================== -->
    <div class="modal fade" id="modalObservaciones" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form id="formObservaciones" method="POST" action="">
                    @csrf
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Evaluar / Rechazar Documento</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <h6 class="font-weight-bold text-dark mb-3" id="nombre-documento-modal"></h6>
                        <input type="hidden" name="estado" id="estado-input">
                        
                        <div class="form-group">
                            <label for="observaciones" class="font-weight-bold text-muted">Motivo del rechazo u observación:</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" rows="4" placeholder="Ej. El documento no cuenta con los sellos correspondientes..." required style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger font-weight-bold">
                            <i class="fas fa-paper-plane mr-1"></i> Guardar Observación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@stop

@section('js')
<script>
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