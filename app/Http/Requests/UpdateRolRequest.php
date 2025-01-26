<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRolRequest extends FormRequest
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
                Rule::unique('roles')->ignore($id)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.string' => 'El nombre debe ser un texto.',
            'nombre.max' => 'El nombre no debe ser mayor a 50 caracteres.',
            'nombre.unique' => 'El nombre ya está en uso.'
        ];
    }

}
