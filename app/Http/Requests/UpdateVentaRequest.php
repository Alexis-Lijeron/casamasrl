<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'exists:clientes,id'],
            'fecha_venta' => ['required', 'date'],
            'total' => ['required', 'numeric', 'min:0'],
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
            'cliente_id.required' => 'El cliente es requerido.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',
            'fecha_venta.required' => 'La fecha de venta es requerida.',
            'fecha_venta.date' => 'La fecha de venta debe ser una fecha válida.',
            'total.required' => 'El total es requerido.',
            'total.numeric' => 'El total debe ser un número.',
            'total.min' => 'El total no puede ser negativo.',
            'productos.required' => 'Los productos son requeridos.',
        ];
    }
}
