<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use Illuminate\Http\Request;

class DependenciaController extends Controller
{
   
    public function index()
    {
        $dependencias = Dependencia::orderBy('nombre', 'asc')->get();
        return view('dependencias.index', compact('dependencias'));
    }

    public function create()
    {
        return view('dependencias.create');
    }

 public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'tipo_convenio' => 'required|in:SS,RP,AMBOS',
        ]);

        Dependencia::create($request->all());
        return redirect()->route('dependencias.index')->with('success', 'Dependencia registrada exitosamente.');
    }

  public function edit(Dependencia $dependencia)
    {
        return view('dependencias.edit', compact('dependencia'));
    }

    public function update(Request $request, Dependencia $dependencia)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'tipo_convenio' => 'required|in:SS,RP,AMBOS',
        ]);

        // Manejar el checkbox de activa
        $data = $request->all();
        $data['activa'] = $request->has('activa') ? 1 : 0;

        $dependencia->update($data);
        return redirect()->route('dependencias.index')->with('success', 'Dependencia actualizada correctamente.');
    } 
   public function destroy(Dependencia $dependencia)
    {
        $dependencia->delete();
        return redirect()->route('dependencias.index')->with('success', 'Dependencia eliminada.');
    }
}
