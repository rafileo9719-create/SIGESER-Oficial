@extends('adminlte::page')

@section('title', 'Dependencias')

@section('content_header')
    <h1>Catálogo de Dependencias y Convenios</h1>
@stop

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <a href="{{ route('dependencias.create') }}" class="btn btn-primary font-weight-bold">
                <i class="fas fa-plus-circle"></i> Agregar Nueva Dependencia
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre de la Dependencia</th>
                            <th>Tipo de Convenio</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dependencias as $dep)
                        <tr>
                            <td class="align-middle">{{ $dep->id }}</td>
                            <td class="align-middle font-weight-bold">{{ $dep->nombre }}</td>
                            <td class="align-middle">
                                @if($dep->tipo_convenio == 'AMBOS')
                                    <span class="badge badge-success px-2 py-1"><i class="fas fa-handshake"></i> SS y RP</span>
                                @elseif($dep->tipo_convenio == 'SS')
                                    <span class="badge badge-info px-2 py-1"><i class="fas fa-users"></i> Solo Servicio Social</span>
                                @else
                                    <span class="badge badge-warning px-2 py-1 text-dark"><i class="fas fa-user-tie"></i> Solo Residencia</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if($dep->activa)
                                    <span class="badge badge-light border border-success text-success px-3 py-1 font-weight-bold">
                                        <i class="fas fa-check-circle"></i> Activa
                                    </span>
                                @else
                                    <span class="badge badge-light border border-danger text-danger px-3 py-1 font-weight-bold">
                                        <i class="fas fa-times-circle"></i> Inactiva
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <a href="{{ route('dependencias.edit', $dep) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('dependencias.destroy', $dep) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta dependencia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop