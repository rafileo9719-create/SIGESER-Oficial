@extends('adminlte::page')

@section('title', 'Editar Carrera')

@section('content_header')
    <h1>Editar Carrera</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('carreras.update', $carrera) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Clave:</label>
                    <input type="text" name="clave" class="form-control" value="{{ old('clave', $carrera->clave) }}" required>
                </div>
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $carrera->nombre) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop