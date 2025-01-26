<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'monto' => 'required|numeric',
            // 'fecha_pago' => 'required|date',
            // 'descripcion' => 'nullable|string',
            // 'estado' => 'required|boolean',
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
        ];
    }
    
    public function messages(): array
    {
        return [
            'monto.required' => 'El monto es requerido',
            'monto.numeric' => 'El monto debe ser un número',
            'fecha_pago.required' => 'La fecha de pago es requerida',
            'fecha_pago.date' => 'La fecha de pago debe ser una fecha',
            'descripcion.string' => 'La descripción debe ser un texto',
            'estado.required' => 'El estado es requerido',
            'estado.boolean' => 'El estado debe ser un booleano',
            'metodo_pago_id.required' => 'El método de pago es requerido',
            'metodo_pago_id.exists' => 'El método de pago no existe',
        ];
    }
}
