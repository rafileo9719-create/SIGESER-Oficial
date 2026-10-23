@extends('adminlte::page')

@section('title', 'Editar Dependencia')

@section('content_header')
    <h1>Editar Dependencia</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dependencias.update', $dependencia) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre de la Dependencia/Empresa:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $dependencia->nombre) }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tipo de Convenio:</label>
                        <select name="tipo_convenio" class="form-control" required>
                            <option value="AMBOS" {{ old('tipo_convenio', $dependencia->tipo_convenio) == 'AMBOS' ? 'selected' : '' }}>Ambos (SS y RP)</option>
                            <option value="SS" {{ old('tipo_convenio', $dependencia->tipo_convenio) == 'SS' ? 'selected' : '' }}>Solo Servicio Social</option>
                            <option value="RP" {{ old('tipo_convenio', $dependencia->tipo_convenio) == 'RP' ? 'selected' : '' }}>Solo Residencia Profesional</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Sector:</label>
                        <input type="text" name="sector" class="form-control" value="{{ old('sector', $dependencia->sector) }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Teléfono:</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $dependencia->telefono) }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Dirección:</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $dependencia->direccion) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Nombre del Titular:</label>
                        <input type="text" name="titular_nombre" class="form-control" value="{{ old('titular_nombre', $dependencia->titular_nombre) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Puesto del Titular:</label>
                        <input type="text" name="titular_puesto" class="form-control" value="{{ old('titular_puesto', $dependencia->titular_puesto) }}">
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="form-check">
                            <input type="checkbox" name="activa" value="1" class="form-check-input" id="activa" {{ $dependencia->activa ? 'checked' : '' }}>
                            <label class="form-check-label" for="activa">Dependencia Activa (tiene convenio vigente)</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('dependencias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop