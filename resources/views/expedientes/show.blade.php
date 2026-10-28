@extends('adminlte::page')

@section('title', 'Detalle del Expediente')

@section('content_header')
    <h1>Expediente: {{ $expediente->alumno->nombre }} ({{ $expediente->alumno->matricula }})</h1>
@stop

@section('content')
    <div class="row">
        <!-- Tarjeta de Información del Alumno -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">{{ $expediente->alumno->nombre }}</h3>
                    <p class="text-muted text-center">{{ $expediente->alumno->carrera }} - {{ $expediente->alumno->semestre }}° Semestre</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Matrícula:</b> <a class="float-right">{{ $expediente->alumno->matricula }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Proceso:</b> <a class="float-right">{{ $expediente->proceso == 'SS' ? 'Servicio Social' : 'Residencia' }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Dependencia:</b> <a class="float-right">{{ $expediente->dependencia->nombre }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Periodo:</b> <a class="float-right">{{ $expediente->periodo }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Documentos (Checklist) -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Documentos y Entregas</h3>
                </div>
                <div class="card-body">
                    
                    <!-- Barra de Progreso -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <strong>Progreso del Expediente</strong>
                            <span>{{ $docsAprobados }} de {{ $totalDocs }} Aprobados ({{ $progreso }}%)</span>
                        </div>
                        <div class="progress mt-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progreso }}%" aria-valuenow="{{ $progreso }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Tabla de Documentos -->
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expediente->documentos as $doc)
                            <tr>
                                <td>{{ $doc->nombre_documento }}</td>
                                <td class="text-center">
                                    @if($doc->estado == 'Pendiente')
                                        <span class="badge badge-warning">Pendiente</span>
                                    @elseif($doc->estado == 'Entregado')
                                        <span class="badge badge-info">Entregado</span>
                                    @elseif($doc->estado == 'Aprobado')
                                        <span class="badge badge-success">Aprobado</span>
                                    @else
                                        <span class="badge badge-danger">Rechazado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" title="Descargar Formato">
                                        <i class="fas fa-download"></i> Generar
                                    </button>
                                    <button class="btn btn-sm btn-success" title="Subir Escaneado">
                                        <i class="fas fa-upload"></i> Subir
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    No se encontraron documentos asignados a este expediente. <br>
                                    (Recuerda que los documentos se crean automáticamente al registrar el expediente).
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop