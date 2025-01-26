<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proveedor_id' => ['required', 'exists:proveedores,id'],
            'fecha_compra' => ['required', 'date'],
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
            'proveedor_id.required' => 'El proveedor es requerido.',
            'proveedor_id.exists' => 'El proveedor seleccionado no existe.',
            'fecha_compra.required' => 'La fecha de compra es requerida.',
            'fecha_compra.date' => 'La fecha de compra debe ser una fecha válida.',
            'total.required' => 'El total es requerido.',
            'total.numeric' => 'El total debe ser un número.',
            'total.min' => 'El total no puede ser negativo.',
            'productos.required' => 'Los productos son requeridos.',
        ];
    }
}
