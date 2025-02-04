<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'nombre' => ['required', 'string', 'max:50'],
            'apellido' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('usuarios')->ignore($id)
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                function ($attribute, $value, $fail) {
                    if ($value && !preg_match('/[a-z]/', $value)) {
                        $fail('La contraseña debe incluir al menos una letra minúscula.');
                    }
                    if ($value && !preg_match('/[A-Z]/', $value)) {
                        $fail('La contraseña debe incluir al menos una letra mayúscula.');
                    }
                    if ($value && !preg_match('/[\d@$!%*?&]/', $value)) {
                        $fail('La contraseña debe incluir al menos un número o un carácter especial.');
                    }
                },
            ],
            'telefono' => [
                'required',
                'string',
                'max:20',
                Rule::unique('usuarios')->ignore($id)
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
