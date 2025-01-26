<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('dashboard.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('dashboard.usuarios.create', compact('roles'));
    }

    public function store(StoreUsuarioRequest $request)
    {
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make('1234678'),
            'rol_id' => $request->rol_id  
        ]);
        
        if (!$usuario) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        session()->flash('guardado', '¡Guardado! El usuario ha sido guardado exitosamente.');
        return redirect()->route('usuarios.index');
    }

    public function show(Usuario $usuario)
    {
        //
    }

    public function edit(string $id)
    {
        $usuario = Usuario::find($id);
        $roles = Rol::all();
        if (!$usuario) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        return view('dashboard.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(UpdateUsuarioRequest $request, string $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->rol_id = $request->rol_id;
        $usuario->save();
        
        session()->flash('actualizado', '¡Actualizado! El usuario ha sido actualizado exitosamente.');
        return redirect()->route('usuarios.index');
    }

    public function destroy(string $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }
        
        $usuario->delete();
        session()->flash('eliminado', '¡Eliminado! El usuario ha sido eliminado exitosamente.');
        return redirect()->route('usuarios.index');
    }
    
}
