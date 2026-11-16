<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Si el usuario tiene el rol de 'alumno', lo mandamos a su panel
        if ($user->hasRole('alumno')) {
            return view('alumno_dashboard');
        }

        // Si es admin o encargado, ven el panel con estadísticas globales
        return view('dashboard');
    }
}