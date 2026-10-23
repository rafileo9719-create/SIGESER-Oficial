@extends('adminlte::page')

@section('title', 'Nueva Dependencia')

@section('content_header')
    <h1>Agregar Dependencia</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dependencias.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre de la Dependencia/Empresa:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tipo de Convenio:</label>
                        <select name="tipo_convenio" class="form-control" required>
                            <option value="AMBOS" {{ old('tipo_convenio') == 'AMBOS' ? 'selected' : '' }}>Ambos (SS y RP)</option>
                            <option value="SS" {{ old('tipo_convenio') == 'SS' ? 'selected' : '' }}>Solo Servicio Social</option>
                            <option value="RP" {{ old('tipo_convenio') == 'RP' ? 'selected' : '' }}>Solo Residencia Profesional</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Sector:</label>
                        <input type="text" name="sector" class="form-control" value="{{ old('sector') }}" placeholder="Ej. Público, Privado">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Teléfono:</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Dirección:</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Nombre del Titular:</label>
                        <input type="text" name="titular_nombre" class="form-control" value="{{ old('titular_nombre') }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Puesto del Titular:</label>
                        <input type="text" name="titular_puesto" class="form-control" value="{{ old('titular_puesto') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Guardar Dependencia</button>
                <a href="{{ route('dependencias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop