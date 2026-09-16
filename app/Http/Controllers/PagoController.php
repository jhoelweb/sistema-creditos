<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagoRequest;
use App\Http\Requests\UpdatePagoRequest;
use App\Models\Credito;
use App\Models\Pago;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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

            // Verificar permisos
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

            // Verificar que el crédito esté activo
            if ($credito->estado !== 'Activo') {

                throw ValidationException::withMessages([
                    'credito_id' =>
                        'Este crédito no está activo y no permite pagos.'
                ]);
            }

            // Verificar que el pago no supere el saldo
            if (
                (float) $datos['monto'] >
                (float) $credito->saldo
            ) {

                throw ValidationException::withMessages([
                    'monto' =>
                        'El pago no puede ser mayor al saldo pendiente de $' .
                        number_format(
                            (float) $credito->saldo,
                            2
                        ) . '.'
                ]);
            }

            // Registrar pago
            Pago::create($datos);

            // Calcular nuevo saldo
            $nuevoSaldo =
                (float) $credito->saldo -
                (float) $datos['monto'];

            // Evitar saldo negativo
            if ($nuevoSaldo < 0) {
                $nuevoSaldo = 0;
            }

            // Determinar estado
            $nuevoEstado = $nuevoSaldo <= 0
                ? 'Pagado'
                : 'Activo';

            // Actualizar crédito
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
        $usuario = auth()->user();

        if ($usuario->rol !== 'Administrador') {

            abort(
                403,
                'No tienes permiso para editar pagos.'
            );
        }

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

            /*
             * Bloquear el pago mientras se modifica.
             */
            $pagoActual = Pago::where(
                'id',
                $pago->id
            )
                ->lockForUpdate()
                ->firstOrFail();


            /*
             * Bloquear también el crédito.
             */
            $credito = Credito::where(
                'id',
                $pagoActual->credito_id
            )
                ->lockForUpdate()
                ->firstOrFail();


            /*
             * Calculamos cuánto saldo había
             * antes de aplicar el pago actual.
             *
             * Ejemplo:
             *
             * Total: $1,100
             * Pago actual: $300
             * Saldo actual: $800
             *
             * Saldo disponible para editar:
             *
             * $800 + $300 = $1,100
             */
            $saldoDisponible =
                (float) $credito->saldo +
                (float) $pagoActual->monto;


            /*
             * Verificar que el nuevo pago
             * no supere el total disponible.
             */
            if (
                (float) $datos['monto'] >
                $saldoDisponible
            ) {

                throw ValidationException::withMessages([
                    'monto' =>
                        'El nuevo monto no puede superar el saldo disponible de $' .
                        number_format(
                            $saldoDisponible,
                            2
                        ) . '.'
                ]);
            }


            /*
             * Calcular nuevo saldo.
             */
            $nuevoSaldo =
                $saldoDisponible -
                (float) $datos['monto'];


            if ($nuevoSaldo < 0) {
                $nuevoSaldo = 0;
            }


            /*
             * Determinar estado del crédito.
             */
            if ($credito->estado === 'Cancelado') {

                $nuevoEstado = 'Cancelado';

            } elseif ($nuevoSaldo <= 0) {

                $nuevoEstado = 'Pagado';

            } elseif (
                $credito->fecha_vencimiento->isPast()
            ) {

                $nuevoEstado = 'Vencido';

            } else {

                $nuevoEstado = 'Activo';
            }


            /*
             * Actualizar pago.
             */
            $pagoActual->update([
                'fecha_pago' =>
                    $datos['fecha_pago'],

                'monto' =>
                    $datos['monto'],

                'referencia' =>
                    $datos['referencia'] ?? null,

                'observaciones' =>
                    $datos['observaciones'] ?? null,
            ]);


            /*
             * Actualizar saldo y estado.
             */
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

            /*
             * Bloquear el pago.
             */
            $pagoActual = Pago::where(
                'id',
                $pago->id
            )
                ->lockForUpdate()
                ->firstOrFail();


            /*
             * Bloquear el crédito.
             */
            $credito = Credito::where(
                'id',
                $pagoActual->credito_id
            )
                ->lockForUpdate()
                ->firstOrFail();


            /*
             * Al eliminar el pago,
             * devolvemos ese dinero al saldo.
             */
            $nuevoSaldo =
                (float) $credito->saldo +
                (float) $pagoActual->monto;


            /*
             * El saldo nunca puede superar
             * el total del crédito.
             */
            if (
                $nuevoSaldo >
                (float) $credito->total_credito
            ) {
                $nuevoSaldo =
                    (float) $credito->total_credito;
            }


            /*
             * Determinar nuevo estado.
             */
            if ($credito->estado === 'Cancelado') {

                $nuevoEstado = 'Cancelado';

            } elseif ($nuevoSaldo <= 0) {

                $nuevoEstado = 'Pagado';

            } elseif (
                $credito->fecha_vencimiento->isPast()
            ) {

                $nuevoEstado = 'Vencido';

            } else {

                $nuevoEstado = 'Activo';
            }


            /*
             * Eliminar el pago.
             */
            $pagoActual->delete();


            /*
             * Restaurar el saldo del crédito.
             */
            $credito->update([
                'saldo' => $nuevoSaldo,
                'estado' => $nuevoEstado,
            ]);
        });


        return redirect()
            ->route('pagos.index')
            ->with(
                'success',
                'Pago eliminado correctamente y saldo restaurado.'
            );
    }
}