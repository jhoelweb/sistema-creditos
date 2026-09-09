<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagoRequest;
use App\Models\Credito;
use App\Models\Pago;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        // ========================================
        // ADMINISTRADOR
        // ========================================

        if ($usuario->rol === 'Administrador') {

            // El administrador puede ver todos los pagos
            $pagos = Pago::with('credito.cliente')
                ->orderBy('id', 'desc')
                ->get();
        }

        // ========================================
        // CLIENTE / USUARIO
        // ========================================

        else {

            // Verificar que tenga cliente asociado
            if (!$usuario->cliente_id) {

                abort(
                    403,
                    'Tu cuenta no está asociada a un cliente.'
                );
            }

            // Solamente mostrar pagos
            // pertenecientes a sus créditos
            $pagos = Pago::with('credito.cliente')
                ->whereHas('credito', function ($query) use ($usuario) {

                    $query->where(
                        'cliente_id',
                        $usuario->cliente_id
                    );

                })
                ->orderBy('id', 'desc')
                ->get();
        }

        return view(
            'pagos.index',
            compact('pagos')
        );
    }


    public function create()
    {
        $usuario = auth()->user();

        // ========================================
        // ADMINISTRADOR
        // ========================================

        if ($usuario->rol === 'Administrador') {

            // Puede registrar pagos sobre
            // cualquier crédito activo
            $creditos = Credito::with('cliente')
                ->where('estado', 'Activo')
                ->where('saldo', '>', 0)
                ->orderBy('id', 'desc')
                ->get();
        }

        // ========================================
        // CLIENTE / USUARIO
        // ========================================

        else {

            // Verificar cliente asociado
            if (!$usuario->cliente_id) {

                abort(
                    403,
                    'Tu cuenta no está asociada a un cliente.'
                );
            }

            // Solamente mostrar sus propios créditos
            $creditos = Credito::with('cliente')
                ->where(
                    'cliente_id',
                    $usuario->cliente_id
                )
                ->where('estado', 'Activo')
                ->where('saldo', '>', 0)
                ->orderBy('id', 'desc')
                ->get();
        }

        return view(
            'pagos.create',
            compact('creditos')
        );
    }


    public function store(StorePagoRequest $request)
    {
        $datos = $request->validated();

        DB::transaction(function () use ($datos) {

            // ========================================
            // BUSCAR Y BLOQUEAR EL CRÉDITO
            // ========================================

            $credito = Credito::where(
                'id',
                $datos['credito_id']
            )
                ->lockForUpdate()
                ->firstOrFail();

            $usuario = auth()->user();

            // ========================================
            // SEGURIDAD DEL CLIENTE
            // ========================================

            if ($usuario->rol !== 'Administrador') {

                // El crédito debe pertenecer
                // al cliente que inició sesión
                if (
                    $credito->cliente_id !==
                    $usuario->cliente_id
                ) {

                    abort(
                        403,
                        'No tienes permiso para registrar un pago en este crédito.'
                    );
                }
            }

            // ========================================
            // VERIFICAR ESTADO
            // ========================================

            if ($credito->estado !== 'Activo') {

                abort(
                    422,
                    'Este crédito no está activo y no permite pagos.'
                );
            }

            // ========================================
            // VERIFICAR SALDO
            // ========================================

            if (
                (float) $datos['monto'] >
                (float) $credito->saldo
            ) {

                abort(
                    422,
                    'El pago no puede ser mayor al saldo pendiente.'
                );
            }

            // ========================================
            // REGISTRAR PAGO
            // ========================================

            Pago::create($datos);

            // ========================================
            // CALCULAR NUEVO SALDO
            // ========================================

            $nuevoSaldo =
                (float) $credito->saldo -
                (float) $datos['monto'];

            // Evitar saldo negativo
            if ($nuevoSaldo < 0) {

                $nuevoSaldo = 0;
            }

            // ========================================
            // DETERMINAR NUEVO ESTADO
            // ========================================

            $nuevoEstado = $nuevoSaldo <= 0
                ? 'Pagado'
                : 'Activo';

            // ========================================
            // ACTUALIZAR CRÉDITO
            // ========================================

            $credito->update([
                'saldo' => $nuevoSaldo,
                'estado' => $nuevoEstado,
            ]);
        });

        return redirect()
            ->route('pagos.index')
            ->with(
                'success',
                'Pago registrado correctamente.'
            );
    }


    public function show(Pago $pago)
    {
        $usuario = auth()->user();

        $pago->load('credito.cliente');

        // ========================================
        // SEGURIDAD
        // ========================================

        if ($usuario->rol !== 'Administrador') {

            // El pago debe pertenecer
            // a un crédito del cliente conectado
            if (
                $pago->credito->cliente_id !==
                $usuario->cliente_id
            ) {

                abort(
                    403,
                    'No tienes permiso para consultar este pago.'
                );
            }
        }

        return view(
            'pagos.show',
            compact('pago')
        );
    }


    public function recibo(Pago $pago)
    {
        $usuario = auth()->user();

        $pago->load('credito.cliente');

        // ========================================
        // SEGURIDAD DEL RECIBO
        // ========================================

        if ($usuario->rol !== 'Administrador') {

            if (
                $pago->credito->cliente_id !==
                $usuario->cliente_id
            ) {

                abort(
                    403,
                    'No tienes permiso para consultar este recibo.'
                );
            }
        }

        return view(
            'pagos.recibo',
            compact('pago')
        );
    }


    public function edit(Pago $pago)
    {
        $pago->load('credito.cliente');

        return view(
            'pagos.edit',
            compact('pago')
        );
    }


    public function update(
        \Illuminate\Http\Request $request,
        Pago $pago
    ) {
        return redirect()
            ->route('pagos.index')
            ->with(
                'success',
                'La edición de pagos se realizará posteriormente.'
            );
    }


    public function destroy(Pago $pago)
    {
        return redirect()
            ->route('pagos.index')
            ->with(
                'success',
                'La eliminación de pagos se realizará posteriormente.'
            );
    }
}