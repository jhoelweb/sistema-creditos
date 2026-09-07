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
        $pagos = Pago::with('credito.cliente')
            ->orderBy('id', 'desc')
            ->get();

        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        $creditos = Credito::with('cliente')
            ->where('estado', 'Activo')
            ->where('saldo', '>', 0)
            ->orderBy('id', 'desc')
            ->get();

        return view('pagos.create', compact('creditos'));
    }

    public function store(StorePagoRequest $request)
    {
        $datos = $request->validated();

        DB::transaction(function () use ($datos) {

            // Buscar y bloquear el crédito mientras se registra el pago
            $credito = Credito::where('id', $datos['credito_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Verificar que el crédito esté activo
            if ($credito->estado !== 'Activo') {
                abort(
                    422,
                    'Este crédito no está activo y no permite pagos.'
                );
            }

            // Verificar que el pago no supere el saldo pendiente
            if ((float) $datos['monto'] > (float) $credito->saldo) {
                abort(
                    422,
                    'El pago no puede ser mayor al saldo pendiente.'
                );
            }

            // Registrar el pago
            Pago::create($datos);

            // Calcular el nuevo saldo
            $nuevoSaldo = (float) $credito->saldo
                - (float) $datos['monto'];

            // Evitar saldos negativos por decimales
            if ($nuevoSaldo < 0) {
                $nuevoSaldo = 0;
            }

            // Determinar el nuevo estado
            $nuevoEstado = $nuevoSaldo <= 0
                ? 'Pagado'
                : 'Activo';

            // Actualizar el crédito
            $credito->update([
                'saldo' => $nuevoSaldo,
                'estado' => $nuevoEstado,
            ]);
        });

        return redirect()
            ->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    public function show(Pago $pago)
    {
        $pago->load('credito.cliente');

        return view('pagos.show', compact('pago'));
    }

    public function recibo(Pago $pago)
    {
        $pago->load('credito.cliente');

        return view('pagos.recibo', compact('pago'));
    }

    public function edit(Pago $pago)
    {
        $pago->load('credito.cliente');

        return view('pagos.edit', compact('pago'));
    }

    public function update(\Illuminate\Http\Request $request, Pago $pago)
    {
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