@extends('adminlte::page')

@section('title', 'Expedientes')

@section('content_header')
    <h1>Listado de Expedientes</h1>
@stop

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="row w-100 align-items-center">
                <div class="col-md-6">
                    <a href="{{ route('expedientes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Registrar Nuevo Expediente
                    </a>
                </div>
                <div class="col-md-6">
                    <!-- Buscador por Matrícula o Nombre -->
                    <form action="{{ route('expedientes.index') }}" method="GET" class="form-inline float-right">
                        <div class="input-group">
                            <input type="text" name="buscar" class="form-control" placeholder="Buscar por matrícula o nombre..." value="{{ request('buscar') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Alumno</th>
                            <th>Proceso</th>
                            <th>Dependencia</th>
                            <th>Periodo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expedientes as $exp)
                        <tr>
                            <td class="align-middle">{{ $exp->id }}</td>
                            <td class="align-middle">
                                <a href="{{ route('expedientes.show', $exp) }}" class="font-weight-bold">
                                    {{ $exp->alumno->nombre ?? 'N/A' }} <br>
                                    <small class="text-muted">{{ $exp->alumno->matricula ?? '' }}</small>
                                </a>
                            </td>
                            <td class="align-middle">
                                @if($exp->proceso == 'SS')
                                    <span class="badge text-bg-info">Servicio Social</span>
                                @else
                                    <span class="badge text-bg-warning">Residencia</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $exp->dependencia->nombre ?? 'N/A' }}</td>
                            <td class="align-middle">{{ $exp->periodo }}</td>
                            <td class="align-middle"><span class="badge text-bg-primary">Activo</span></td>
                            <td class="align-middle">
                                <a href="{{ route('expedientes.show', $exp) }}" class="btn btn-sm btn-info" title="Ver Expediente">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No se encontraron expedientes con esos criterios de búsqueda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop