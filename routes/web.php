<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CarreraController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupos de TODAS las rutas protegidas en un solo bloque
Route::middleware('auth')->group(function () {
    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de Carreras
    Route::resource('carreras', CarreraController::class);
    Route::resource('dependencias', \App\Http\Controllers\DependenciaController::class);
    
    // Pruebas de búsqueda
    Route::get('/prueba-busqueda', [PruebaController::class, 'index'])->name('prueba.busqueda');
    Route::get('/alumnos/buscar/{matricula}', [AlumnoController::class, 'buscar'])->name('alumnos.buscar');
    // CRUD de Expedientes
    Route::resource('expedientes', \App\Http\Controllers\ExpedienteController::class);
    // Ruta para actualizar el estado de un documento específico
    Route::post('/documentos/{documento}/estado', [\App\Http\Controllers\ExpedienteController::class, 'updateEstado'])->name('documentos.updateEstado');
    // Ruta para subir archivos a un documento específico
    Route::post('/documentos/{documento}/subir', [\App\Http\Controllers\ExpedienteController::class, 'subirArchivo'])->name('documentos.subir');
});

require __DIR__.'/auth.php';
