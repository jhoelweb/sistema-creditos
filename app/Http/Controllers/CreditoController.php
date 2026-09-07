<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditoRequest;
use App\Http\Requests\UpdateCreditoRequest;
use App\Models\Cliente;
use App\Models\Credito;
use Illuminate\Http\Request;

class CreditoController extends Controller
{
    public function index(Request $request)
    {
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

    public function store(StoreCreditoRequest $request)
    {
        $datos = $request->validated();

        $monto = (float) $datos['monto'];
        $tasa = (float) $datos['tasa_interes'];

        // Calcular interés
        $interes = $monto * ($tasa / 100);

        // Calcular total
        $total = $monto + $interes;

        // Valores iniciales del crédito
        $datos['total_credito'] = $total;
        $datos['saldo'] = $total;

        // Calcular fecha de vencimiento
        $datos['fecha_vencimiento'] = date(
            'Y-m-d',
            strtotime(
                '+' . (int) $datos['plazo'] . ' months',
                strtotime($datos['fecha_otorgamiento'])
            )
        );

        // Todo crédito nuevo inicia activo
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

    public function update(
        UpdateCreditoRequest $request,
        Credito $credito
    ) {
        $datos = $request->validated();

        $monto = (float) $datos['monto'];
        $tasa = (float) $datos['tasa_interes'];

        // Recalcular interés
        $interes = $monto * ($tasa / 100);

        // Recalcular total
        $total = $monto + $interes;

        $datos['total_credito'] = $total;

        /*
        Mantener temporalmente el saldo actual.
        Más adelante ajustaremos esta lógica para que,
        si el crédito ya tiene pagos, el saldo se calcule
        correctamente.
        */
        $datos['saldo'] = $credito->saldo;

        // Recalcular fecha de vencimiento
        $datos['fecha_vencimiento'] = date(
            'Y-m-d',
            strtotime(
                '+' . (int) $datos['plazo'] . ' months',
                strtotime($datos['fecha_otorgamiento'])
            )
        );

        // Mantener un crédito cancelado como cancelado
        if ($credito->estado === 'Cancelado') {
            $datos['estado'] = 'Cancelado';
        } elseif ($credito->saldo <= 0) {
            $datos['estado'] = 'Pagado';
        } elseif (
            strtotime($datos['fecha_vencimiento']) < strtotime(date('Y-m-d'))
        ) {
            $datos['estado'] = 'Vencido';
        } else {
            $datos['estado'] = 'Activo';
        }

        $credito->update($datos);

        return redirect()
            ->route('creditos.index')
            ->with('success', 'Crédito actualizado correctamente.');
    }

    public function destroy(Credito $credito)
    {
        $credito->update([
            'estado' => 'Cancelado'
        ]);

        return redirect()
            ->route('creditos.index')
            ->with('success', 'Crédito cancelado correctamente.');
    }
}