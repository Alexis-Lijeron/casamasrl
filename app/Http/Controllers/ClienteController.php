<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('dashboard.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('dashboard.clientes.create');
    }

    public function store(StoreClienteRequest $request)
    {
        $cliente = Cliente::create($request->all());
        
        if (!$cliente) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        session()->flash('guardado', '¡Guardado! El cliente ha sido guardado exitosamente.');
        return redirect()->route('clientes.index');
    }

    public function show(Cliente $cliente)
    {
        //
    }

    public function edit(string $id)
    {
        $cliente = Cliente::find($id);
        return view('dashboard.clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, string $id)
    {
        $cliente = Cliente::find($id);
        
        if (!$cliente) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        $cliente->update($request->all());
        session()->flash('actualizado', '¡Actualizado! El cliente ha sido actualizado exitosamente.');
        return redirect()->route('clientes.index');
    }

    public function destroy(string $id)
    {
        $cliente = Cliente::find($id);
        
        if (!$cliente) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        $cliente->delete();
        session()->flash('eliminado', '¡Eliminado! El cliente ha sido eliminado exitosamente.');
        return redirect()->route('clientes.index');
    }
}
