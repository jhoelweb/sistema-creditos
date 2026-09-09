<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $usuario = auth()->user();

        // ========================================
        // ADMINISTRADOR
        // ========================================

        if ($usuario->rol === 'Administrador') {

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

        }

        // ========================================
        // CLIENTE / USUARIO
        // ========================================

        else {

            // Verificar que tenga un cliente asociado
            if (!$usuario->cliente_id) {
                abort(
                    403,
                    'Tu cuenta no está asociada a un cliente.'
                );
            }

            // Mostrar únicamente su información
            $clientes = Cliente::where(
                'id',
                $usuario->cliente_id
            )->get();

            $buscar = null;
        }

        return view(
            'clientes.index',
            compact('clientes', 'buscar')
        );
    }


    public function create()
    {
        return view('clientes.create');
    }


    public function store(StoreClienteRequest $request)
    {
        $datos = $request->validated();

        return DB::transaction(function () use ($datos) {

            // Guardamos la contraseña antes de crear el cliente
            $password = $datos['password'];

            // La contraseña no se guarda en la tabla clientes
            unset($datos['password']);

            // Todo cliente nuevo inicia activo
            $datos['estado'] = true;

            // Crear el cliente
            $cliente = Cliente::create($datos);

            // Crear la cuenta de acceso
            User::create([
                'name' => $cliente->nombres . ' ' . $cliente->apellidos,
                'email' => $cliente->correo,
                'password' => Hash::make($password),
                'rol' => 'Usuario',
                'cliente_id' => $cliente->id,
            ]);

            return redirect()
                ->route('clientes.index')
                ->with(
                    'success',
                    'Cliente registrado correctamente. Su cuenta de acceso también fue creada.'
                );
        });
    }


    public function show(Cliente $cliente)
    {
        $usuario = auth()->user();

        // ========================================
        // SEGURIDAD
        // ========================================

        // Si es Usuario, solamente puede
        // consultar su propio cliente
        if (
            $usuario->rol !== 'Administrador' &&
            $usuario->cliente_id !== $cliente->id
        ) {
            abort(
                403,
                'No tienes permiso para consultar este cliente.'
            );
        }

        // Cargar créditos del cliente
        $cliente->load('creditos');

        return view(
            'clientes.show',
            compact('cliente')
        );
    }


    public function edit(Cliente $cliente)
    {
        return view(
            'clientes.edit',
            compact('cliente')
        );
    }


    public function update(
        UpdateClienteRequest $request,
        Cliente $cliente
    ) {
        $datos = $request->validated();

        // Conservamos el estado actual del cliente
        $datos['estado'] = $cliente->estado;

        // Actualizar datos del cliente
        $cliente->update($datos);

        // Buscar cuenta de acceso
        $usuario = $cliente->usuario;

        if ($usuario) {

            // Actualizar datos de acceso
            $usuario->update([
                'name' => $cliente->nombres . ' ' . $cliente->apellidos,
                'email' => $cliente->correo,
            ]);
        }

        return redirect()
            ->route('clientes.index')
            ->with(
                'success',
                'Cliente y cuenta de acceso actualizados correctamente.'
            );
    }


    public function destroy(Cliente $cliente)
    {
        $cliente->update([
            'estado' => false
        ]);

        return redirect()
            ->route('clientes.index')
            ->with(
                'success',
                'Cliente desactivado correctamente.'
            );
    }
}