@extends('adminlte::page')

@section('title', 'Nueva Carrera')

@section('content_header')
    <h1>Agregar Carrera</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('carreras.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Clave:</label>
                    <input type="text" name="clave" class="form-control" value="{{ old('clave') }}" required>
                    @error('clave') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop