<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Http\Requests\StoreRolRequest;
use App\Http\Requests\UpdateRolRequest;
use Illuminate\Support\Str;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('dashboard.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('dashboard.roles.create');
    }

    public function store(StoreRolRequest $request)
    {
        $rol = Rol::create([
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre), // Genera el slug automáticamente
            'description' => $request->description
        ]);

        if (!$rol) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }

        session()->flash('guardado', '¡Guardado! El rol ha sido guardado exitosamente.');
        return redirect()->route('roles.index');
    }

    public function show(Rol $rol)
    {
        //
    }

    public function edit(string $id)
    {
        $rol = Rol::find($id);
        if (!$rol) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        return view('dashboard.roles.edit', compact('rol'));
    }

    public function update(UpdateRolRequest $request, string $id)
    {
        $rol = Rol::find($id);
        if (!$rol) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }

        $rol->update([
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre), // Regenera el slug si el nombre cambia
            'description' => $request->description
        ]);

        session()->flash('actualizado', '¡Actualizado! El rol ha sido actualizado exitosamente.');
        return redirect()->route('roles.index');
    }

    public function destroy(string $id)
    {
        $rol = Rol::find($id);
        if (!$rol) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        $rol->delete();
        session()->flash('eliminado', '¡Eliminado! El rol ha sido eliminado exitosamente.');
        return redirect()->route('roles.index');
    }
}
