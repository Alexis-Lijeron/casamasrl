<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Http\Requests\StoreProveedorRequest;
use App\Http\Requests\UpdateProveedorRequest;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('dashboard.proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('dashboard.proveedores.create');
    }

    public function store(StoreProveedorRequest $request)
    {
        $proveedor = Proveedor::create($request->all());
        
        if (!$proveedor) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        session()->flash('guardado', '¡Guardado! El proveedor ha sido guardado exitosamente.');
        return redirect()->route('proveedor.index');
    }

    public function show(Proveedor $proveedores)
    {
        //
    }

    public function edit(string $id)
    {
        $proveedor = Proveedor::find($id);
        return view('dashboard.proveedores.edit', compact('proveedor'));
    }

    public function update(UpdateProveedorRequest $request, string $id)
    {
        $proveedor = Proveedor::find($id);
        
        if (!$proveedor) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        $proveedor->update($request->all());
        session()->flash('actualizado', '¡Actualizado! El proveedor ha sido actualizado exitosamente.');
        return redirect()->route('proveedor.index');
    }

    public function destroy(string $id)
    {
        $proveedor = Proveedor::find($id);
        
        if (!$proveedor) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        $proveedor->delete();
        session()->flash('eliminado', '¡Eliminado! El proveedor ha sido eliminado exitosamente.');
        return redirect()->route('proveedor.index');
    }
}
