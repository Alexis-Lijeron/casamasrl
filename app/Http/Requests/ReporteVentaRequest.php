<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReporteVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'usuario' => ['nullable', 'integer'],
            // 'cliente' => ['nullable', 'integer'],
            // 'producto' => ['nullable', 'integer'],
            // 'categoria' => ['nullable', 'integer'],
            'fecha_desde' => ['required', 'date'],
            'fecha_hasta' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            // 'usuario.integer' => 'El campo usuario debe ser un número entero.',
            // 'cliente.integer' => 'El campo cliente debe ser un número entero.',
            // 'producto.integer' => 'El campo producto debe ser un número entero.',
            // 'categoria.integer' => 'El campo categoría debe ser un número entero.',
            'fecha_desde.required' => 'El campo fecha desde es obligatorio.',
            'fecha_desde.date' => 'El campo fecha desde debe ser una fecha válida.',
            'fecha_hasta.required' => 'El campo fecha hasta es obligatorio.',
            'fecha_hasta.date' => 'El campo fecha hasta debe ser una fecha válida.',
        ];
    }
}
