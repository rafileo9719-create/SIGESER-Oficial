@extends('adminlte::page')

@section('title', 'Expedientes')

@section('content_header')
    <h1>Listado de Expedientes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('expedientes.create') }}" class="btn btn-primary">Registrar Nuevo Expediente</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alumno</th>
                        <th>Proceso</th>
                        <th>Dependencia</th>
                        <th>Periodo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expedientes as $exp)
                    <tr>
                        <td>{{ $exp->id }}</td>
                        <td>
                            <a href="{{ route('expedientes.show', $exp) }}">
                                {{ $exp->alumno->nombre ?? 'N/A' }} ({{ $exp->alumno->matricula ?? '' }})
                            </a>
                        </td>
                        <td>
                            @if($exp->proceso == 'SS')
                                <span class="badge badge-info">Servicio Social</span>
                            @else
                                <span class="badge badge-warning">Residencia</span>
                            @endif
                        </td>
                        <td>{{ $exp->dependencia->nombre ?? 'N/A' }}</td>
                        <td>{{ $exp->periodo }}</td>
                        <td><span class="badge badge-primary">Activo</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop