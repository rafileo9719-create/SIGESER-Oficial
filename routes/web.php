<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\DashboardController; // <-- ¡ESTA LÍNEA FALTABA!
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\ExpedienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta del Dashboard protegida
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Grupos de TODAS las rutas protegidas en un solo bloque
Route::middleware('auth')->group(function () {
    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de Carreras
    Route::resource('carreras', CarreraController::class);
    Route::resource('dependencias', DependenciaController::class);
    
    // Pruebas de búsqueda
    Route::get('/prueba-busqueda', [PruebaController::class, 'index'])->name('prueba.busqueda');
    Route::get('/alumnos/buscar/{matricula}', [AlumnoController::class, 'buscar'])->name('alumnos.buscar');
    
    // CRUD de Expedientes
    Route::resource('expedientes', ExpedienteController::class);
    
    // Rutas para documentos del expediente
    Route::post('/documentos/{documento}/estado', [ExpedienteController::class, 'updateEstado'])->name('documentos.updateEstado');
    Route::post('/documentos/{documento}/subir', [ExpedienteController::class, 'subirArchivo'])->name('documentos.subir');

    // Ruta para guardar observaciones
    Route::post('/expedientes/{expediente}/observaciones', [ExpedienteController::class, 'storeObservacion'])->name('expedientes.observaciones.store');
});

require __DIR__.'/auth.php';
