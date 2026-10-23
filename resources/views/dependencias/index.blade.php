@extends('adminlte::page')

@section('title', 'Dependencias')

@section('content_header')
    <h1>Catálogo de Dependencias y Convenios</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('dependencias.create') }}" class="btn btn-primary">Agregar Nueva Dependencia</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Convenio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dependencias as $dep)
                    <tr>
                        <td>{{ $dep->id }}</td>
                        <td>{{ $dep->nombre }}</td>
                        <td>
                            @if($dep->tipo_convenio == 'AMBOS')
                                <span class="badge badge-success">SS y RP</span>
                            @elseif($dep->tipo_convenio == 'SS')
                                <span class="badge badge-info">Solo Servicio Social</span>
                            @else
                                <span class="badge badge-warning">Solo Residencia</span>
                            @endif
                        </td>
                        <td>
                            @if($dep->activa)
                                <span class="badge badge-primary">Activa</span>
                            @else
                                <span class="badge badge-danger">Inactiva</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('dependencias.edit', $dep) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('dependencias.destroy', $dep) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta dependencia?')">
                                @csrf
                                @method('DELETE')
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