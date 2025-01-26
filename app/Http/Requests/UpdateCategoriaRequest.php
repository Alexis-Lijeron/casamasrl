<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoriaRequest extends FormRequest
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
                Rule::unique('categorias')->ignore($id)
            ],
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
