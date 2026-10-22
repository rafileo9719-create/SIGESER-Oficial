<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::all();
        return view('carreras.index', compact('carreras'));
    }

    public function create()
    {
        return view('carreras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|unique:carreras|max:10',
            'nombre' => 'required|max:255',
        ]);
        Carrera::create($request->all());
        return redirect()->route('carreras.index')->with('success', 'Carrera creada exitosamente.');
    }

    public function edit(Carrera $carrera)
    {
        return view('carreras.edit', compact('carrera'));
    }

    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'clave' => 'required|max:10|unique:carreras,clave,'.$carrera->id,
            'nombre' => 'required|max:255',
        ]);
        $carrera->update($request->all());
        return redirect()->route('carreras.index')->with('success', 'Carrera actualizada correctamente.');
    }

    public function destroy(Carrera $carrera)
    {
        $carrera->delete();
        return redirect()->route('carreras.index')->with('success', 'Carrera eliminada.');
    }
}