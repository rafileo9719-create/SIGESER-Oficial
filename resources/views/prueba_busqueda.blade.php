@extends('adminlte::page')

@section('title', 'Prueba Búsqueda')

@section('content_header')
    <h1>Simulador de Búsqueda de Alumno</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>Matrícula:</label>
                <div class="input-group mb-3">
                    <input type="text" id="matricula" class="form-control" placeholder="Ej. B25795006">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="btn-buscar">Buscar</button>
                    </div>
                </div>
            </div>
            
            <div id="resultado" class="mt-4" style="display: none;">
                <div class="alert alert-success">
                    <h4><i class="icon fas fa-check"></i> Alumno Encontrado</h4>
                    <p><strong>Nombre:</strong> <span id="res-nombre"></span></p>
                    <p><strong>Carrera:</strong> <span id="res-carrera"></span></p>
                    <p><strong>Semestre:</strong> <span id="res-semestre"></span></p>
                    <p><strong>Correo:</strong> <span id="res-correo"></span></p>
                </div>
            </div>
            
            <div id="error" class="alert alert-danger mt-4" style="display: none;">
                Matrícula no encontrada en la base de datos.
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    document.getElementById('btn-buscar').addEventListener('click', async function() {
        const matricula = document.getElementById('matricula').value.trim();
        if (!matricula) return;

        document.getElementById('resultado').style.display = 'none';
        document.getElementById('error').style.display = 'none';
        const btn = this;
        btn.innerHTML = 'Buscando...';
        btn.disabled = true;

        try {
            const response = await fetch(`/alumnos/buscar/${matricula}`);
            if (!response.ok) throw new Error('No encontrado');
            
            const data = await response.json();
            
            document.getElementById('res-nombre').textContent = data.nombre;
            document.getElementById('res-carrera').textContent = data.carrera;
            document.getElementById('res-semestre').textContent = data.semestre;
            document.getElementById('res-correo').textContent = data.correo;
            
            document.getElementById('resultado').style.display = 'block';
        } catch (e) {
            document.getElementById('error').style.display = 'block';
        } finally {
            btn.innerHTML = 'Buscar';
            btn.disabled = false;
        }
    });
</script>
@stop