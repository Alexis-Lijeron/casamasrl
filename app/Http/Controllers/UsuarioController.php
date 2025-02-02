<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('roles')->get();
        return view('dashboard.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('dashboard.usuarios.create', compact('roles'));
    }

    public function store(StoreUsuarioRequest $request)
{
    try {
        \DB::beginTransaction();

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('roles')) {
            $usuario->roles()->sync($request->roles);
        }

        \DB::commit();

        session()->flash('guardado', '¡Guardado! El usuario ha sido guardado exitosamente.');
        return redirect()->route('usuarios.index');

    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('Error al crear usuario: ' . $e->getMessage());

        session()->flash('error', 'Ha ocurrido un error al crear el usuario. Por favor, intenta nuevamente.');
        return redirect()->back()->withInput();
    }
}

    public function show(Usuario $usuario)
    {
        //
    }

    public function edit(string $id)
    {
        $usuario = Usuario::with('roles')->find($id);
        $roles = Rol::all();

        if (!$usuario) {
            session()->flash('error', 'Ha ocurrido un error. Por favor, intenta nuevamente.');
            return redirect()->back();
        }

        return view('dashboard.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(UpdateUsuarioRequest $request, string $id)
{
    try {
        \DB::beginTransaction();

        $usuario = Usuario::findOrFail($id);

        // Actualizar datos básicos
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;

        // Actualizar contraseña solo si se proporcionó una nueva
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        // Actualizar roles
        if ($request->has('roles')) {
            $usuario->roles()->sync($request->roles);
        }

        \DB::commit();

        session()->flash('actualizado', '¡Actualizado! El usuario ha sido actualizado exitosamente.');
        return redirect()->route('usuarios.index');

    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('Error al actualizar usuario: ' . $e->getMessage());

        session()->flash('error', 'Ha ocurrido un error al actualizar el usuario. Por favor, intenta nuevamente.');
        return redirect()->back()->withInput();
    }
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
