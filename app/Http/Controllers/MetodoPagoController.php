<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use App\Http\Requests\StoreMetodoPagoRequest;
use App\Http\Requests\UpdateMetodoPagoRequest;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $metodos_pagos = MetodoPago::all();
        return view('dashboard.metodo_pagos.index', compact('metodos_pagos'));
    }

    public function create()
    {
        return view('dashboard.metodo_pagos.create');
    }

    public function store(StoreMetodoPagoRequest $request)
    {
        $metodo = MetodoPago::create($request->all());
        if (!$metodo) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        session()->flash('guardado', '¡Guardado! El método de pago ha sido guardado exitosamente.');
        return redirect()->route('metodos-pago.index');
    }

    public function show(MetodoPago $metodoPago)
    {
        //
    }

    
    public function edit(string $id)
    {
        $metodo = MetodoPago::find($id);
        return view('dashboard.metodo_pagos.edit', compact('metodo'));
    }

    public function update(UpdateMetodoPagoRequest $request, string $id)
    {
        $metodo = MetodoPago::find($id);
        
        if (!$metodo) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        $metodo->update($request->all());
        session()->flash('actualizado', '¡Actualizado! El método de pago ha sido actualizado exitosamente.');
        return redirect()->route('metodos-pago.index');
    }

    public function destroy(string $id)
    {
        $metodo = MetodoPago::find($id);
        
        if (!$metodo) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        $metodo->delete();
        session()->flash('eliminado', '¡Eliminado! El método de pago ha sido eliminado exitosamente.');
        return redirect()->route('metodos-pago.index');
    }
}
