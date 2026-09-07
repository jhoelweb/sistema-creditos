<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
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

    public function create()
    {
        return view('clientes.create');
    }

    public function store(StoreClienteRequest $request)
    {
        $datos = $request->validated();

        // Todo cliente nuevo inicia activo
        $datos['estado'] = true;

        Cliente::create($datos);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load('creditos');

        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(
        UpdateClienteRequest $request,
        Cliente $cliente
    ) {
        $datos = $request->validated();

        // Conservamos el estado actual del cliente
        $datos['estado'] = $cliente->estado;

        $cliente->update($datos);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

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