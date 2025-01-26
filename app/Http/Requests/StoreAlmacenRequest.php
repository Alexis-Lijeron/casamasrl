<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlmacenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255', 'unique:almacenes'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'productos' => ['nullable', 'json'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'nombre.required' => 'El campo nombre es requerido.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.max' => 'El campo nombre debe tener un máximo de 255 caracteres.',
            'nombre.unique' => 'El nombre del almacén ya está en uso.',
            'descripcion.nullable' => 'El campo descripción es opcional.',
            'descripcion.string' => 'El campo descripción debe ser una cadena de texto.',
            'descripcion.max' => 'El campo descripción debe tener un máximo de 255 caracteres.',
            'productos.nullable' => 'El campo productos es opcional.',
            'productos.json' => 'El campo productos debe ser un JSON válido.',
        ];
    }
}
