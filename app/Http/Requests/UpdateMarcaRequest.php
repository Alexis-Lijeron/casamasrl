<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMarcaRequest extends FormRequest
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
                Rule::unique('marcas')->ignore($id),
            ],
        ];
    }
    
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la marca es requerido.',
            'nombre.string' => 'El nombre de la marca debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la marca no debe ser mayor a 50 caracteres.',
            'nombre.unique' => 'El nombre de la marca ya está en uso.',
        ];
    }
}
