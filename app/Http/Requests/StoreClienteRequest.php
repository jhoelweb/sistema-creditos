<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres' => [
                'required',
                'string',
                'max:100',
            ],

            'apellidos' => [
                'required',
                'string',
                'max:100',
            ],

            'documento_identidad' => [
                'required',
                'string',
                'max:30',
                'unique:clientes,documento_identidad',
            ],

            'telefono' => [
                'required',
                'string',
                'max:20',
            ],

            'correo' => [
                'nullable',
                'email',
                'max:150',
            ],

            'direccion' => [
                'nullable',
                'string',
                'max:500',
            ],

            'estado' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombres.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'documento_identidad.required' => 'El documento de identidad es obligatorio.',
            'documento_identidad.unique' => 'Este documento ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'correo.email' => 'El correo electrónico no es válido.',
        ];
    }
}
