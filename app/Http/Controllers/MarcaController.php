<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::all();
        return view('dashboard.marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('dashboard.marcas.create');
    }

    public function store(StoreMarcaRequest $request)
    {
        $marca = Marca::create($request->all());
        
        if (!$marca) {
            session()->flash('error', 'Ocurrió un error al intentar guardar la marca. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        session()->flash('guardado', 'Marca guardada correctamente.');
        return redirect()->route('marcas.index');
    }

    public function show(Marca $marca)
    {
        //
    }

    public function edit(string $id)
    {
        $marca = Marca::find($id);
        if (!$marca) {
            session()->flash('error', 'Ocurrió un error al intentar editar la marca. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        return view('dashboard.marcas.edit', compact('marca'));
    }

    public function update(UpdateMarcaRequest $request, string $id)
    {
        $marca = Marca::find($id);
        if (!$marca) {
            session()->flash('error', 'Ocurrió un error al intentar actualizar la marca. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        $marca->update($request->all());
        session()->flash('actualizado', 'Marca actualizada correctamente.');
        return redirect()->route('marcas.index');
    }

    public function destroy(string $id)
    {
        $marca = Marca::find($id);
        if (!$marca) {
            session()->flash('error', 'Ocurrió un error al intentar eliminar la marca. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        $marca->delete();
        session()->flash('eliminado', 'Marca eliminada correctamente.');
        return redirect()->route('marcas.index');
    }
}
