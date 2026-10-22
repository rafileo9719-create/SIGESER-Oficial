@extends('adminlte::page')

@section('title', 'Carreras')

@section('content_header')
    <h1>Listado de Carreras</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('carreras.create') }}" class="btn btn-primary">Agregar Carrera</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th><th>Clave</th><th>Nombre</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carreras as $carrera)
                    <tr>
                        <td>{{ $carrera->id }}</td>
                        <td>{{ $carrera->clave }}</td>
                        <td>{{ $carrera->nombre }}</td>
                        <td>
                            <a href="{{ route('carreras.edit', $carrera) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('carreras.destroy', $carrera) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar carrera?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop