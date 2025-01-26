<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMetodoPagoRequest extends FormRequest
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
                Rule::unique('metodo_pagos')->ignore($id),
            ],
        ];
    }
    
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.string' => 'El nombre debe ser un texto.',
            'nombre.max' => 'El nombre debe tener máximo 50 caracteres.',
            'nombre.unique' => 'El nombre ya está en uso.',
        ];
    }
}
