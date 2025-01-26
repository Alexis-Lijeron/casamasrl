<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:50', 'unique:productos'],
            'descripcion' => ['nullable', 'string'],
            'precio_venta' => ['required', 'numeric'],
            'stock_minimo' => ['required', 'numeric'],
            'imagen' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'marca_id' => ['required', 'exists:marcas,id']
        ];
    }
    
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.string' => 'El nombre debe ser una cadena de texto',
            'nombre.max' => 'El nombre no debe exceder los 50 caracteres',
            'nombre.unique' => 'El nombre ya está en uso',
            'descripcion.string' => 'La descripción debe ser una cadena de texto',
            'precio_venta.required' => 'El precio unitario es requerido',
            'precio_venta.numeric' => 'El precio unitario debe ser un número',
            'stock_minimo.required' => 'El stock mínimo es requerido',
            'stock_minimo.numeric' => 'El stock mínimo debe ser un número',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser de tipo png, jpg o jpeg',
            'categoria_id.required' => 'La categoría es requerida',
            'categoria_id.exists' => 'La categoría no existe',
            'marca_id.required' => 'La marca es requerida',
            'marca_id.exists' => 'La marca no existe'
        ];
    }
}
