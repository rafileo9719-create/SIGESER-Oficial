@extends('adminlte::page')

@section('title', 'Mi Panel - Alumno')

@section('content_header')
    <h1>Mi Panel de Estudiante</h1>
@stop

@section('content')
    <!-- Banner de Bienvenida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card text-white" style="background: linear-gradient(135deg, #621132 0%, #8a1b4a 100%); border-radius: 15px;">
                <div class="card-body p-4">
                    <h2 class="font-weight-bold mb-2"><i class="fas fa-user-graduate"></i> ¡Hola, {{ Auth::user()->name }}!</h2>
                    <p class="mb-0 lead">Bienvenido a tu panel de control de Servicio Social y Residencia Profesional.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mis Acciones -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="font-weight-bold text-dark"><i class="fas fa-folder-open text-primary"></i> Mi Expediente</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Desde aquí podrás registrar tu Servicio Social o Residencia Profesional, y subir tus documentos.</p>
                    <a href="{{ route('expedientes.create') }}" class="btn btn-institucional w-100" style="background-color: #621132; color: white; padding: 12px; border-radius: 8px;">
                        <i class="fas fa-plus-circle mr-2"></i> Registrar Nuevo Expediente
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="font-weight-bold text-dark"><i class="fas fa-info-circle text-warning"></i> Instrucciones</h4>
                </div>
                <div class="card-body">
                    <ul class="text-muted pl-3">
                        <li class="mb-2">Asegúrate de tener tus datos personales correctos.</li>
                        <li class="mb-2">El asesor externo solo se podrá registrar <strong>una vez</strong>.</li>
                        <li class="mb-2">Revisa constantemente las observaciones de tus documentos.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop