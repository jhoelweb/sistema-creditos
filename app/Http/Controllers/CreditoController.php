<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Credito;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CreditoController extends Controller
{
    public function index(Request $request)
    {
        // Actualizar créditos vencidos automáticamente
        Credito::where('estado', 'Activo')
            ->where('saldo', '>', 0)
            ->whereDate('fecha_vencimiento', '<', now()->toDateString())
            ->update([
                'estado' => 'Vencido'
            ]);

        $estado = $request->input('estado');

        $creditos = Credito::with('cliente')
            ->when($estado, function ($query, $estado) {
                $query->where('estado', $estado);
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('creditos.index', compact('creditos', 'estado'));
    }

    public function create()
    {
        $clientes = Cliente::where('estado', true)
            ->orderBy('nombres')
            ->get();

        return view('creditos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'fecha_otorgamiento' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'tasa_interes' => ['required', 'numeric', 'min:0'],
            'plazo' => ['required', 'integer', 'min:1'],
        ]);

        $monto = (float) $datos['monto'];
        $tasa = (float) $datos['tasa_interes'];

        // Calcular interés
        $interes = $monto * ($tasa / 100);

        // Calcular total
        $total = $monto + $interes;

        // Guardar cálculos
        $datos['total_credito'] = $total;
        $datos['saldo'] = $total;

        // Calcular fecha de vencimiento
        $datos['fecha_vencimiento'] = Carbon::parse(
            $datos['fecha_otorgamiento']
        )->addMonths(
            $datos['plazo']
        )->format('Y-m-d');

        // Estado inicial
        $datos['estado'] = 'Activo';

        Credito::create($datos);

        return redirect()
            ->route('creditos.index')
            ->with('success', 'Crédito registrado correctamente.');
    }

    public function show(Credito $credito)
    {
        $credito->load('cliente');

        return view('creditos.show', compact('credito'));
    }

    public function edit(Credito $credito)
    {
        $clientes = Cliente::where('estado', true)
            ->orderBy('nombres')
            ->get();

        return view('creditos.edit', compact('credito', 'clientes'));
    }

    public function update(Request $request, Credito $credito)
    {
        $datos = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'fecha_otorgamiento' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'tasa_interes' => ['required', 'numeric', 'min:0'],
            'plazo' => ['required', 'integer', 'min:1'],
        ]);

        $monto = (float) $datos['monto'];
        $tasa = (float) $datos['tasa_interes'];

        // Calcular interés
        $interes = $monto * ($tasa / 100);

        // Calcular total
        $total = $monto + $interes;

        $datos['total_credito'] = $total;

        /*
         * Si el crédito todavía no tiene pagos,
         * el saldo será igual al total.
         *
         * La lógica de pagos la agregaremos
         * en el módulo Pagos.
         */
        $datos['saldo'] = $total;

        // Calcular nueva fecha de vencimiento
        $datos['fecha_vencimiento'] = Carbon::parse(
            $datos['fecha_otorgamiento']
        )->addMonths(
            $datos['plazo']
        )->format('Y-m-d');

        // No cambiar automáticamente un crédito cancelado
        // mientras se está editando.
        if ($credito->estado !== 'Cancelado') {

            if (
                $datos['saldo'] > 0 &&
                Carbon::parse($datos['fecha_vencimiento'])->isPast()
            ) {
                $datos['estado'] = 'Vencido';
            } else {
                $datos['estado'] = 'Activo';
            }
        }

        $credito->update($datos);

        return redirect()
            ->route('creditos.index')
            ->with('success', 'Crédito actualizado correctamente.');
    }

    public function destroy(Credito $credito)
    {
        // Cancelar crédito
        $credito->update([
            'estado' => 'Cancelado'
        ]);

        return redirect()
            ->route('creditos.index')
            ->with('success', 'Crédito cancelado correctamente.');
    }
}
