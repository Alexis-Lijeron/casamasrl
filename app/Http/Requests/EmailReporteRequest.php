<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailReporteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'to' => ['required', 'string'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'to.required' => 'El campo "Para" es requerido',
            'to.string' => 'El campo "Para" debe ser una cadena de caracteres',
            'subject.required' => 'El campo "Asunto" es requerido',
            'subject.string' => 'El campo "Asunto" debe ser una cadena de caracteres',
            'message.required' => 'El campo "Mensaje" es requerido',
            'message.string' => 'El campo "Mensaje" debe ser una cadena de caracteres',
        ];
    }
}
