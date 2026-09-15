<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagoRequest;
use App\Http\Requests\UpdatePagoRequest;
use App\Models\Credito;
use App\Models\Pago;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        if ($usuario->rol === 'Administrador') {

            $pagos = Pago::with('credito.cliente')
                ->orderBy('id', 'desc')
                ->get();

        } else {

            if (!$usuario->cliente_id) {
                abort(
                    403,
                    'Tu cuenta no está asociada a un cliente.'
                );
            }

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

        if ($usuario->rol === 'Administrador') {

            $creditos = Credito::with('cliente')
                ->where('estado', 'Activo')
                ->where('saldo', '>', 0)
                ->orderBy('id', 'desc')
                ->get();

        } else {

            if (!$usuario->cliente_id) {
                abort(
                    403,
                    'Tu cuenta no está asociada a un cliente.'
                );
            }

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

            $credito = Credito::where(
                'id',
                $datos['credito_id']
            )
                ->lockForUpdate()
                ->firstOrFail();

            $usuario = auth()->user();

            if ($usuario->rol !== 'Administrador') {

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

            if ($credito->estado !== 'Activo') {
                abort(
                    422,
                    'Este crédito no está activo y no permite pagos.'
                );
            }

            if (
                (float) $datos['monto'] >
                (float) $credito->saldo
            ) {
                abort(
                    422,
                    'El pago no puede ser mayor al saldo pendiente.'
                );
            }

            Pago::create($datos);

            $nuevoSaldo =
                (float) $credito->saldo -
                (float) $datos['monto'];

            if ($nuevoSaldo < 0) {
                $nuevoSaldo = 0;
            }

            $nuevoEstado = $nuevoSaldo <= 0
                ? 'Pagado'
                : 'Activo';

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

        if ($usuario->rol !== 'Administrador') {

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
        UpdatePagoRequest $request,
        Pago $pago
    ) {
        $datos = $request->validated();

        DB::transaction(function () use ($datos, $pago) {

            $pagoActual = Pago::where(
                'id',
                $pago->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            $credito = Credito::where(
                'id',
                $pagoActual->credito_id
            )
                ->lockForUpdate()
                ->firstOrFail();

            $montoAnterior = (float) $pagoActual->monto;
            $montoNuevo = (float) $datos['monto'];

            /*
             * El saldo actual ya tiene descontado
             * el pago anterior.
             *
             * Por eso primero devolvemos el monto
             * anterior al saldo y luego aplicamos
             * el nuevo monto.
             */

            $saldoDisponible =
                (float) $credito->saldo +
                $montoAnterior;

            if ($montoNuevo > $saldoDisponible) {
                abort(
                    422,
                    'El nuevo monto del pago no puede ser mayor al saldo disponible.'
                );
            }

            $nuevoSaldo =
                $saldoDisponible -
                $montoNuevo;

            if ($nuevoSaldo < 0) {
                $nuevoSaldo = 0;
            }

            /*
             * Actualizar el pago.
             */

            $pagoActual->update([
                'fecha_pago' => $datos['fecha_pago'],
                'monto' => $montoNuevo,
                'referencia' => $datos['referencia'] ?? null,
                'observaciones' => $datos['observaciones'] ?? null,
            ]);

            /*
             * Determinar el nuevo estado del crédito.
             */

            if ($nuevoSaldo <= 0) {

                $nuevoEstado = 'Pagado';

            } elseif (
                $credito->fecha_vencimiento &&
                $credito->fecha_vencimiento->isPast()
            ) {

                $nuevoEstado = 'Vencido';

            } else {

                $nuevoEstado = 'Activo';
            }

            $credito->update([
                'saldo' => $nuevoSaldo,
                'estado' => $nuevoEstado,
            ]);
        });

        return redirect()
            ->route('pagos.index')
            ->with(
                'success',
                'Pago actualizado correctamente.'
            );
    }


    public function destroy(Pago $pago)
    {
        DB::transaction(function () use ($pago) {

            $pagoActual = Pago::where(
                'id',
                $pago->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            $credito = Credito::where(
                'id',
                $pagoActual->credito_id
            )
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * Restaurar el monto del pago
             * al saldo del crédito.
             */

            $nuevoSaldo =
                (float) $credito->saldo +
                (float) $pagoActual->monto;

            if (
                $nuevoSaldo >
                (float) $credito->total_credito
            ) {
                $nuevoSaldo =
                    (float) $credito->total_credito;
            }

            /*
             * Determinar nuevamente el estado.
             */

            if ($nuevoSaldo <= 0) {

                $nuevoEstado = 'Pagado';

            } elseif (
                $credito->fecha_vencimiento &&
                $credito->fecha_vencimiento->isPast()
            ) {

                $nuevoEstado = 'Vencido';

            } else {

                $nuevoEstado = 'Activo';
            }

            $credito->update([
                'saldo' => $nuevoSaldo,
                'estado' => $nuevoEstado,
            ]);

            $pagoActual->delete();
        });

        return redirect()
            ->route('pagos.index')
            ->with(
                'success',
                'Pago eliminado correctamente y el saldo del crédito fue actualizado.'
            );
    }
}