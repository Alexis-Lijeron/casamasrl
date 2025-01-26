<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'nombre_empresa' => [
                'required',
                'string',
                'max:30',
                Rule::unique('proveedores')->ignore($id)
            ],
            'nombre_encargado' => ['required', 'string', 'max:30'],
            'direccion' => ['required', 'string', 'max:100'],
            'telefono' => [
                'required',
                'string',
                'max:20',
                Rule::unique('proveedores')->ignore($id)
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('proveedores')->ignore($id)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_empresa.required' => 'El nombre de la empresa es requerido.',
            'nombre_empresa.string' => 'El nombre de la empresa debe ser una cadena de caracteres.',
            'nombre_empresa.max' => 'El nombre de la empresa debe contener como máximo 30 caracteres.',
            'nombre_empresa.unique' => 'El nombre de la empresa ya está en uso.',
            'nombre_encargado.required' => 'El nombre del encargado es requerido.',
            'nombre_encargado.string' => 'El nombre del encargado debe ser una cadena de caracteres.',
            'nombre_encargado.max' => 'El nombre del encargado debe contener como máximo 30 caracteres.',
            'direccion.required' => 'La dirección es requerida.',
            'direccion.string' => 'La dirección debe ser una cadena de caracteres.',
            'direccion.max' => 'La dirección debe contener como máximo 100 caracteres.',
            'telefono.required' => 'El teléfono es requerido.',
            'telefono.string' => 'El teléfono debe ser una cadena de caracteres.',
            'telefono.max' => 'El teléfono debe contener como máximo 20 caracteres.',
            'telefono.unique' => 'El teléfono ya está en uso.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.string' => 'El correo electrónico debe ser una cadena de caracteres.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.max' => 'El correo electrónico debe contener como máximo 100 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.'
        ];
    }
}
