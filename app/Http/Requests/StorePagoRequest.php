<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'credito_id' => [
                'required',
                'exists:creditos,id',
            ],

            'fecha_pago' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'monto' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'referencia' => [
                'nullable',
                'string',
                'max:100',
            ],

            'observaciones' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'credito_id.required' => 'Debe seleccionar un crédito.',
            'credito_id.exists' => 'El crédito seleccionado no existe.',

            'fecha_pago.required' => 'La fecha del pago es obligatoria.',
            'fecha_pago.date' => 'La fecha del pago no es válida.',
            'fecha_pago.before_or_equal' => 'La fecha del pago no puede ser futura.',

            'monto.required' => 'El monto del pago es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número.',
            'monto.min' => 'El monto debe ser mayor a 0.',

            'referencia.string' => 'La referencia debe ser texto.',
            'referencia.max' => 'La referencia no puede superar los 100 caracteres.',

            'observaciones.string' => 'Las observaciones deben ser texto.',
            'observaciones.max' => 'Las observaciones no pueden superar los 500 caracteres.',
        ];
    }
}
