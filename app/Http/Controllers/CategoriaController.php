<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('dashboard.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('dashboard.categorias.create');
    }

    public function store(StoreCategoriaRequest $request)
    {
        $categoria = Categoria::create($request->all());
        
        if (!$categoria) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        session()->flash('guardado', '¡Guardado! La categoría ha sido guardada exitosamente.');
        return redirect()->route('categorias.index');
    }

    public function show(Categoria $categoria)
    {
        //
    }

    public function edit(string $id)
    {
        $categoria = Categoria::find($id);
        return view('dashboard.categorias.edit', compact('categoria'));
    }

    public function update(UpdateCategoriaRequest $request, string $id)
    {
        $categoria = Categoria::find($id);
        
        if (!$categoria) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        $categoria->update($request->all());
        session()->flash('actualizado', '¡Actualizado! La categoría ha sido actualizada exitosamente.');
        return redirect()->route('categorias.index');
    }

    public function destroy(string $id)
    {
        $categoria = Categoria::find($id);
        
        if (!$categoria) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        $categoria->delete();
        session()->flash('eliminado', '¡Eliminado! La categoría ha sido eliminada exitosamente.');
        return redirect()->route('categorias.index');
    }
}
