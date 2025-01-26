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
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',       // Al menos una letra minúscula
                'regex:/[A-Z]/',       // Al menos una letra mayúscula
                'regex:/[@$!%*?&\d]/', // Al menos un carácter especial o número
            ],
        ], [
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => [
                'regex:/[a-z]/' => 'La contraseña debe incluir al menos una letra minúscula.',
                'regex:/[A-Z]/' => 'La contraseña debe incluir al menos una letra mayúscula.',
                'regex:/[@$!%*?&\d]/' => 'La contraseña debe incluir al menos un carácter especial o un número.',
            ],
        ]);

        if ($validator->fails()) {
            // Personalizar los mensajes de error según las reglas no cumplidas
            $messages = [];
            $password = $request->password;

            if (!preg_match('/[a-z]/', $password)) {
                $messages[] = 'Falta una letra minúscula.';
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $messages[] = 'Falta una letra mayúscula.';
            }
            if (!preg_match('/[@$!%*?&\d]/', $password)) {
                $messages[] = 'Falta un carácter especial o un número.';
            }
            if (strlen($password) < 8) {
                $messages[] = 'La contraseña debe tener al menos 8 caracteres.';
            }

            // Redirigir con los mensajes personalizados
            return redirect()->back()
                ->withErrors(['password' => implode(' ', $messages)])
                ->withInput();
        }

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
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

        // Validar la contraseña si se incluye en la solicitud
        if ($request->filled('password')) {
            $password = $request->password;
            $messages = [];

            // Validar cada criterio de la contraseña
            if (strlen($password) < 8) {
                $messages[] = 'La contraseña debe tener al menos 8 caracteres.';
            }
            if (!preg_match('/[a-z]/', $password)) {
                $messages[] = 'Falta una letra minúscula.';
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $messages[] = 'Falta una letra mayúscula.';
            }
            if (!preg_match('/[@$!%*?&\d]/', $password)) {
                $messages[] = 'Falta un carácter especial o un número.';
            }

            // Si hay errores, redirigir con los mensajes
            if (!empty($messages)) {
                return redirect()->back()
                    ->withErrors(['password' => implode(' ', $messages)])
                    ->withInput();
            }

            // Encriptar la contraseña si pasa la validación
            $usuario->password = Hash::make($password);
        }

        // Actualizar otros campos del usuario
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
