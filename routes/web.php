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

    // Pruebas de búsqueda
    Route::get('/prueba-busqueda', [PruebaController::class, 'index'])->name('prueba.busqueda');
    Route::get('/alumnos/buscar/{matricula}', [AlumnoController::class, 'buscar'])->name('alumnos.buscar');
});

require __DIR__.'/auth.php';
