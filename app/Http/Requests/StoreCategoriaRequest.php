<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:50', 'unique:categorias'],
            'descripcion' => ['nullable', 'string'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe ser mayor a 50 caracteres.',
            'nombre.unique' => 'El nombre ya está en uso.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
        ];
    }
}
