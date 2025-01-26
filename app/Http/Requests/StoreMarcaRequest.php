<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarcaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:50', 'unique:marcas'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la marca es requerido.',
            'nombre.string' => 'El nombre de la marca debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la marca no debe ser mayor a 50 caracteres.',
            'nombre.unique' => 'El nombre de la marca ya está en uso.'
        ];
    }
}
