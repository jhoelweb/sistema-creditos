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
        // Actualizar automáticamente créditos vencidos
        Credito::where('estado', 'Activo')
            ->where('saldo', '>', 0)
            ->whereDate(
                'fecha_vencimiento',
                '<',
                now()->toDateString()
            )
            ->update([
                'estado' => 'Vencido'
            ]);

        $usuario = auth()->user();

        // ========================================
        // ADMINISTRADOR
        // ========================================

        if ($usuario->rol === 'Administrador') {

            $estado = $request->input('estado');

            $creditos = Credito::with('cliente')
                ->when($estado, function ($query, $estado) {
                    $query->where('estado', $estado);
                })
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

            $estado = $request->input('estado');

            // Mostrar solamente los créditos
            // pertenecientes al cliente conectado
            $creditos = Credito::with('cliente')
                ->where(
                    'cliente_id',
                    $usuario->cliente_id
                )
                ->when($estado, function ($query, $estado) {
                    $query->where('estado', $estado);
                })
                ->orderBy('id', 'desc')
                ->get();
        }

        return view(
            'creditos.index',
            compact('creditos', 'estado')
        );
    }


    public function create()
    {
        $clientes = Cliente::where('estado', true)
            ->orderBy('nombres')
            ->get();

        return view(
            'creditos.create',
            compact('clientes')
        );
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
            ->with(
                'success',
                'Crédito registrado correctamente.'
            );
    }


    public function show(Credito $credito)
    {
        $usuario = auth()->user();

        // ========================================
        // SEGURIDAD
        // ========================================

        // Si es Usuario, solamente puede
        // consultar sus propios créditos
        if (
            $usuario->rol !== 'Administrador' &&
            $usuario->cliente_id !== $credito->cliente_id
        ) {

            abort(
                403,
                'No tienes permiso para consultar este crédito.'
            );
        }

        $credito->load('cliente', 'pagos');

        return view(
            'creditos.show',
            compact('credito')
        );
    }


    public function edit(Credito $credito)
    {
        $clientes = Cliente::where('estado', true)
            ->orderBy('nombres')
            ->get();

        return view(
            'creditos.edit',
            compact('credito', 'clientes')
        );
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

        // Obtener la suma de todos los pagos realizados
        $totalPagado = (float) $credito->pagos()->sum('monto');

        // Calcular nuevamente el saldo pendiente
        $nuevoSaldo = $total - $totalPagado;

        // Evitar saldo negativo
        if ($nuevoSaldo < 0) {
            $nuevoSaldo = 0;
        }

        $datos['saldo'] = $nuevoSaldo;

        // Recalcular fecha de vencimiento
        $datos['fecha_vencimiento'] = date(
            'Y-m-d',
            strtotime(
                '+' . (int) $datos['plazo'] . ' months',
                strtotime($datos['fecha_otorgamiento'])
            )
        );

        // Determinar correctamente el estado
        if ($credito->estado === 'Cancelado') {

            $datos['estado'] = 'Cancelado';

        } elseif ($nuevoSaldo <= 0) {

            $datos['estado'] = 'Pagado';

        } elseif (
            strtotime($datos['fecha_vencimiento'])
            < strtotime(date('Y-m-d'))
        ) {

            $datos['estado'] = 'Vencido';

        } else {

            $datos['estado'] = 'Activo';
        }

        $credito->update($datos);

        return redirect()
            ->route('creditos.index')
            ->with(
                'success',
                'Crédito actualizado correctamente.'
            );
    }


    public function destroy(Credito $credito)
    {
        $credito->update([
            'estado' => 'Cancelado'
        ]);

        return redirect()
            ->route('creditos.index')
            ->with(
                'success',
                'Crédito cancelado correctamente.'
            );
    }
}