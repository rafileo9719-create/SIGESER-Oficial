@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Panel de Control</h1>
@stop

@section('content')
    <!-- Banner de Bienvenida Institucional -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card text-white" style="background: linear-gradient(135deg, #621132 0%, #8a1b4a 100%); border-radius: 15px; box-shadow: 0 4px 15px rgba(98, 17, 50, 0.3);">
                <div class="card-body p-4">
                    <h2 class="font-weight-bold mb-2"><i class="fas fa-graduation-cap"></i> Bienvenido a SIGESER</h2>
                    <p class="mb-0 lead" style="font-size: 1.1rem; opacity: 0.9;">Sistema de Gestión del Servicio Social y Residencia Profesional del Instituto Tecnológico Superior de Tepeaca.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- PRUEBA DE SPATIE: Solo visible para administradores -->
    @role('admin')
        <div class="alert alert-success shadow-sm" style="border-left: 5px solid #28a745;">
            <strong><i class="fas fa-shield-alt"></i> Acceso de Administrador:</strong> El sistema de permisos (Spatie) está funcionando correctamente. Tienes control total sobre SIGESER.
        </div>
    @endrole

    <!-- Tarjetas de Estadísticas -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white" style="border-top: 4px solid #621132; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div class="inner">
                    <h3 class="text-dark font-weight-bold">{{ \App\Models\Expediente::count() }}</h3>
                    <p class="text-muted">Expedientes Totales</p>
                </div>
                <div class="icon" style="color: #621132; opacity: 0.2;">
                    <i class="fas fa-folder-open"></i>
                </div>
                <a href="{{ route('expedientes.index') }}" class="small-box-footer" style="background: #621132; color: white; border-radius: 0 0 5px 5px;">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white" style="border-top: 4px solid #28a745; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div class="inner">
                    <h3 class="text-dark font-weight-bold">{{ \App\Models\Expediente::where('proceso', 'SS')->count() }}</h3>
                    <p class="text-muted">En Servicio Social</p>
                </div>
                <div class="icon" style="color: #28a745; opacity: 0.2;">
                    <i class="fas fa-handshake"></i>
                </div>
                <a href="{{ route('expedientes.index') }}" class="small-box-footer" style="background: #28a745; color: white; border-radius: 0 0 5px 5px;">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white" style="border-top: 4px solid #ffc107; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div class="inner">
                    <h3 class="text-dark font-weight-bold">{{ \App\Models\Expediente::where('proceso', 'RP')->count() }}</h3>
                    <p class="text-muted">En Residencia Prof.</p>
                </div>
                <div class="icon" style="color: #ffc107; opacity: 0.2;">
                    <i class="fas fa-user-tie"></i>
                </div>
                <a href="{{ route('expedientes.index') }}" class="small-box-footer" style="background: #ffc107; color: #212529; border-radius: 0 0 5px 5px;">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white" style="border-top: 4px solid #17a2b8; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div class="inner">
                    <h3 class="text-dark font-weight-bold">{{ \App\Models\Dependencia::count() }}</h3>
                    <p class="text-muted">Dependencias</p>
                </div>
                <div class="icon" style="color: #17a2b8; opacity: 0.2;">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('dependencias.index') }}" class="small-box-footer" style="background: #17a2b8; color: white; border-radius: 0 0 5px 5px;">Ver catálogo <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Tabla de Actividad Reciente y Accesos Rápidos -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: none;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="font-weight-bold text-dark"><i class="fas fa-clock text-primary"></i> Últimos Expedientes Registrados</h4>
                </div>
                <div class="card-body p-0 mt-3">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0">Alumno</th>
                                <th class="border-0">Proceso</th>
                                <th class="border-0">Dependencia</th>
                                <th class="border-0 text-right">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Expediente::with('alumno', 'dependencia')->latest()->take(5)->get() as $exp)
                                <tr>
                                    <td class="align-middle">
                                        <a href="{{ route('expedientes.show', $exp) }}" class="text-dark font-weight-bold" style="text-decoration: none;">
                                            {{ $exp->alumno->nombre ?? 'N/A' }} <br>
                                            <small class="text-muted">{{ $exp->alumno->matricula ?? '' }}</small>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        @if($exp->proceso == 'SS')
                                            <span class="badge badge-success px-2 py-1">SS</span>
                                        @else
                                            <span class="badge badge-warning px-2 py-1">RP</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ \Illuminate\Support\Str::limit($exp->dependencia->nombre ?? 'N/A', 25) }}</td>
                                    <td class="align-middle text-right text-muted">{{ $exp->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No hay expedientes recientes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: none;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="font-weight-bold text-dark"><i class="fas fa-bolt text-warning"></i> Acciones Rápidas</h4>
                </div>
                <div class="card-body">
                {{-- Todos los usuarios logueados pueden crear un expediente --}}
                <a href="{{ route('expedientes.create') }}" class="btn btn-block mb-3" style="background-color: #621132; color: white; border-radius: 8px; padding: 12px;">
                    <i class="fas fa-plus-circle mr-2"></i> Nuevo Expediente
                </a>

                {{-- SOLO el admin y el encargado pueden crear dependencias y carreras --}}
                @role('admin|encargado')
                    <a href="{{ route('dependencias.create') }}" class="btn btn-outline-dark btn-block mb-3" style="border-radius: 8px; padding: 12px;">
                        <i class="fas fa-building mr-2"></i> Nueva Dependencia
                    </a>
                    <a href="{{ route('carreras.create') }}" class="btn btn-outline-dark btn-block" style="border-radius: 8px; padding: 12px;">
                        <i class="fas fa-graduation-cap mr-2"></i> Nueva Carrera
                    </a>
                @endrole
                </div>
            </div>
            
            <!-- Panel de conexión a Servicios Escolares -->
            <div class="card mt-3" style="border-radius: 10px; background-color: #f8f9fa; border: 1px dashed #ccc;">
                <div class="card-body text-center">
                    <i class="fas fa-server fa-3x text-muted mb-3"></i>
                    <h5 class="font-weight-bold">Base de Datos Madre</h5>
                    <p class="text-muted text-sm mb-0">Conectado al sistema de Servicios Escolares</p>
                    <span class="badge badge-info mt-2">Pendiente de API</span>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<!-- PASO 1: CHATBOT FLOTANTE ESTILO WHATSAPP -->
<div id="chat-box" class="card shadow-lg" style="display: none; position: fixed; bottom: 90px; right: 20px; width: 300px; z-index: 9999; border-radius: 15px; overflow: hidden;">
    <div class="card-header text-white" style="background-color: #621132;">
        <h5 class="card-title mb-0"><i class="fas fa-robot"></i> Asistente SIGESER</h5>
        <button type="button" class="close text-white" onclick="document.getElementById('chat-box').style.display='none'">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="card-body" style="height: 250px; overflow-y: auto; background-color: #f8f9fa;">
        <div class="p-2 mb-2 bg-white rounded shadow-sm" style="width: 85%;">
            <small class="text-muted">SIGESER:</small><br>
            ¡Hola! Soy tu asistente virtual. ¿En qué te puedo ayudar hoy?
        </div>
    </div>
    <div class="card-footer bg-white p-2">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Escribe un mensaje...">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Botón flotante para abrir el chat -->
<div id="chat-widget" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
    <button class="btn btn-lg rounded-circle shadow" style="background-color: #621132; color: white;" onclick="document.getElementById('chat-box').style.display='block'">
        <i class="fas fa-comments"></i>
    </button>
</div>
@stop