<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'required|string|max:20',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[@$!%*?&\d]/',
            ],
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.string' => 'El nombre debe ser una cadena de caracteres',
            'nombre.max' => 'El nombre no debe exceder los 50 caracteres',
            'apellido.required' => 'El apellido es requerido',
            'apellido.string' => 'El apellido debe ser una cadena de caracteres',
            'apellido.max' => 'El apellido no debe exceder los 50 caracteres',
            'email.required' => 'El email es requerido',
            'email.string' => 'El email debe ser una cadena de caracteres',
            'email.email' => 'El email debe ser una dirección de correo válida',
            'email.max' => 'El email no debe exceder los 255 caracteres',
            'email.unique' => 'El email ya está en uso',
            'password.required' => 'La contraseña es requerida',
            'password.string' => 'La contraseña debe ser una cadena de caracteres',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'telefono.required' => 'El teléfono es requerido',
            'telefono.string' => 'El teléfono debe ser una cadena de caracteres',
            'telefono.max' => 'El teléfono no debe exceder los 20 caracteres',
            'telefono.unique' => 'El teléfono ya está en uso',
            'rol_id.required' => 'El rol es requerido',
            'rol_id.exists' => 'El rol seleccionado no es válido'
        ];
    }
}
