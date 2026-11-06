@extends('adminlte::page')

@section('title', 'Nuevo Expediente')

@section('content_header')
    <h1>Registro de Nuevo Expediente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('expedientes.store') }}" method="POST" id="form-expediente">
                @csrf
                
                <div class="row">
                    <!-- Búsqueda de Alumno -->
                    <div class="col-md-6 form-group">
                        <label>Matrícula del Alumno:</label>
                        <div class="input-group">
                            <input type="text" id="matricula" name="matricula" class="form-control" placeholder="Ej. B25795006" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="btn-buscar">Buscar</button>
                            </div>
                        </div>
                        <small id="alumno-info" class="text-success" style="display:none;"></small>
                    </div>

                    <!-- Proceso -->
                    <div class="col-md-3 form-group">
                        <label>Proceso:</label>
                        <select name="proceso" id="proceso" class="form-control" required>
                            <option value="SS">Servicio Social</option>
                            <option value="RP">Residencia Profesional</option>
                        </select>
                    </div>

                    <!-- Periodo -->
                    <div class="col-md-3 form-group">
                        <label>Periodo:</label>
                        <input type="text" name="periodo" class="form-control" placeholder="Ej. Junio-Dic 2026" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Dependencia -->
                    <div class="col-md-6 form-group">
                        <label>Dependencia / Empresa (Convenio):</label>
                        <select name="dependencia_id" class="form-control" required>
                            <option value="">Seleccione una dependencia...</option>
                            @foreach($dependencias as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->nombre }} ({{ $dep->tipo_convenio_institucional }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nombre del Programa / Proyecto -->
                    <div class="col-md-6 form-group">
                        <label>Nombre del Programa / Proyecto:</label>
                        <input type="text" name="nombre_programa_proyecto" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Fecha de Inicio:</label>
                        <input type="date" name="fecha_inicio" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Fecha de Fin:</label>
                        <input type="date" name="fecha_fin" class="form-control" required>
                    </div>
                </div>

                <!-- CAMPOS EXCLUSIVOS DE SERVICIO SOCIAL (Se ocultan si es RP) -->
                <div id="campos-ss" class="row bg-light p-3 rounded">
                    <div class="col-12"><h5>Datos específicos de Servicio Social</h5></div>
                    <div class="col-md-4 form-group">
                        <label>Tipo de Programa:</label>
                        <select name="tipo_programa_ss" class="form-control">
                            <option value="Educativo">Educativo</option>
                            <option value="Desarrollo a la comunidad">Desarrollo a la comunidad</option>
                            <option value="Medio ambiente">Medio ambiente</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Modalidad:</label>
                        <select name="modalidad_ss" class="form-control">
                            <option value="Presencial">Presencial</option>
                            <option value="En línea">En línea</option>
                            <option value="Mixta">Mixta</option>
                        </select>
                    </div>
                </div>

                <!-- CAMPOS EXCLUSIVOS DE RESIDENCIA (Se ocultan si es SS) -->
                <div id="campos-rp" class="row bg-light p-3 rounded" style="display:none;">
                    <div class="col-12"><h5>Datos específicos de Residencia</h5></div>
                    <div class="col-md-6 form-group">
                        <label>Número de Afiliación IMSS:</label>
                        <input type="text" name="numero_afiliacion_imss" class="form-control" 
                            maxlength="11" 
                            pattern="\d{11}" 
                            title="Debe ingresar exactamente 11 dígitos numéricos"
                            placeholder="Ej. 12345678901"
                            value="{{ old('numero_afiliacion_imss') }}">
                        <small class="text-muted">Ingrese los 11 dígitos sin espacios ni guiones.</small>
                    </div>
                    
                    <div class="col-md-6 form-group">
                        <label>Asesor Interno:</label>
                        <input type="text" name="asesor_interno" class="form-control">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Guardar Expediente</button>
                    <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    // Lógica para buscar al alumno
    document.getElementById('btn-buscar').addEventListener('click', async function() {
        const matricula = document.getElementById('matricula').value.trim();
        if (!matricula) return;
        
        const info = document.getElementById('alumno-info');
        info.style.display = 'none';

        try {
            const response = await fetch(`/alumnos/buscar/${matricula}`);
            if (!response.ok) throw new Error('No encontrado');
            const data = await response.json();
            
            info.textContent = `Alumno: ${data.nombre} | Carrera: ${data.carrera}`;
            info.style.display = 'block';
        } catch (e) {
            info.textContent = 'Matrícula no encontrada.';
            info.classList.remove('text-success');
            info.classList.add('text-danger');
            info.style.display = 'block';
        }
    });

    // Lógica para ocultar/mostrar campos según el proceso
    document.getElementById('proceso').addEventListener('change', function() {
        const ss = document.getElementById('campos-ss');
        const rp = document.getElementById('campos-rp');
        
        if (this.value === 'SS') {
            ss.style.display = 'flex';
            rp.style.display = 'none';
        } else {
            ss.style.display = 'none';
            rp.style.display = 'flex';
        }
    });
</script>
@stop