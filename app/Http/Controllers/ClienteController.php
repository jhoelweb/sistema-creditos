<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Mostrar todos los clientes y permitir búsqueda.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $clientes = Cliente::query()
            ->when($buscar, function ($query, $buscar) {
                $query->where('nombres', 'like', "%{$buscar}%")
                    ->orWhere('apellidos', 'like', "%{$buscar}%")
                    ->orWhere('documento_identidad', 'like', "%{$buscar}%")
                    ->orWhere('telefono', 'like', "%{$buscar}%");
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('clientes.index', compact('clientes', 'buscar'));
    }

    /**
     * Mostrar formulario para registrar un cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guardar un nuevo cliente.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'documento_identidad' => ['required', 'string', 'max:30', 'unique:clientes,documento_identidad'],
            'telefono' => ['required', 'string', 'max:20'],
            'correo' => ['nullable', 'email', 'max:150'],
            'direccion' => ['nullable', 'string', 'max:500'],
            'estado' => ['nullable', 'boolean'],
        ]);

        $datos['estado'] = $request->has('estado');

        Cliente::create($datos);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    /**
     * Mostrar información de un cliente.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Mostrar formulario para editar un cliente.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar un cliente.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $datos = $request->validate([
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'documento_identidad' => [
                'required',
                'string',
                'max:30',
                Rule::unique('clientes', 'documento_identidad')
                    ->ignore($cliente->id),
            ],
            'telefono' => ['required', 'string', 'max:20'],
            'correo' => ['nullable', 'email', 'max:150'],
            'direccion' => ['nullable', 'string', 'max:500'],
            'estado' => ['nullable', 'boolean'],
        ]);

        $datos['estado'] = $request->has('estado');

        $cliente->update($datos);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Desactivar un cliente.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->update([
            'estado' => false
        ]);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente desactivado correctamente.');
    }
}