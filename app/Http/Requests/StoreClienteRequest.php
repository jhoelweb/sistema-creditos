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
                'required',
                'email',
                'max:150',
                'unique:users,email',
            ],

            'direccion' => [
                'nullable',
                'string',
                'max:500',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
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

            'nombres.required' =>
                'El nombre es obligatorio.',

            'apellidos.required' =>
                'Los apellidos son obligatorios.',

            'documento_identidad.required' =>
                'El documento de identidad es obligatorio.',

            'documento_identidad.unique' =>
                'Este documento ya está registrado.',

            'telefono.required' =>
                'El teléfono es obligatorio.',

            'correo.required' =>
                'El correo electrónico es obligatorio.',

            'correo.email' =>
                'El correo electrónico no es válido.',

            'correo.unique' =>
                'Este correo ya está utilizado por otro usuario.',

            'password.required' =>
                'La contraseña es obligatoria.',

            'password.min' =>
                'La contraseña debe tener al menos 8 caracteres.',

            'password.confirmed' =>
                'Las contraseñas no coinciden.',
        ];
    }
}
