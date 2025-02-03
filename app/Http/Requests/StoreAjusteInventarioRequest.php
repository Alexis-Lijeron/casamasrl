<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAjusteInventarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha' => ['required', 'date'],
            'tipo' => ['required', 'string'],
            'descripcion' => ['required', 'string'],
            'productos' => ['required', 'json', function ($attribute, $value, $fail) {
                $productos = json_decode($value, true);
                if (!is_array($productos) || count($productos) === 0) {
                    $fail('El campo productos debe contener al menos un producto.');
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.string' => 'El tipo debe ser una cadena de texto.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'productos.required' => 'Los productos son requeridos.',
        ];
    }
}
