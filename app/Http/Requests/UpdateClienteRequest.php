<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'nombre' => [
                'required',
                'string',
                'max:50',
            ],
            'apellido' => ['required', 'string', 'max:50'],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:100',
                Rule::unique('clientes')->ignore($id)
            ],
            'telefono' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('clientes')->ignore($id),
            ],
            'genero' => ['required', 'string', 'max:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.string' => 'El nombre debe ser un texto.',
            'nombre.max' => 'El nombre no debe ser mayor a 50 caracteres.',
            'apellido.required' => 'El apellido es requerido.',
            'apellido.string' => 'El apellido debe ser un texto.',
            'apellido.max' => 'El apellido no debe ser mayor a 50 caracteres.',
            'email.string' => 'El email debe ser un texto.',
            'email.email' => 'El email debe ser un correo electrónico válido.',
            'email.max' => 'El email no debe ser mayor a 100 caracteres.',
            'email.unique' => 'El email ya está en uso.',
            'telefono.string' => 'El teléfono debe ser un texto.',
            'telefono.max' => 'El teléfono no debe ser mayor a 20 caracteres.',
            'telefono.unique' => 'El teléfono ya está en uso.',
            'genero.required' => 'El género es requerido.',
            'genero.string' => 'El género debe ser un texto.',
            'genero.max' => 'El género no debe ser mayor a 1 caracter.',
        ];
    }
}
