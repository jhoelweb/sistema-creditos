<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CreditoController;
use App\Http\Controllers\PagoController;


// ========================================
// INICIO
// ========================================

Route::get('/', function () {
    return redirect()->route('login');
});


// ========================================
// AUTENTICACIÓN
// ========================================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ========================================
// DASHBOARD
// ========================================

Route::get('/dashboard', function () {

    $usuario = auth()->user();


    // ========================================
    // ADMINISTRADOR
    // ========================================

    if ($usuario->rol === 'Administrador') {

        $totalClientes = \App\Models\Cliente::where(
            'estado',
            true
        )->count();

        $creditosActivos = \App\Models\Credito::where(
            'estado',
            'Activo'
        )->count();

        $pagosRegistrados = \App\Models\Pago::count();

        $saldoPendiente = \App\Models\Credito::where(
            'saldo',
            '>',
            0
        )->sum('saldo');

        $creditosVencidos = \App\Models\Credito::where(
            'estado',
            'Vencido'
        )->count();

    }


    // ========================================
    // CLIENTE / USUARIO
    // ========================================

    else {

        $cliente = $usuario->cliente;


        // Verificar que el usuario tenga
        // un cliente asociado

        if (!$cliente) {

            abort(
                403,
                'Tu cuenta no está asociada a un cliente.'
            );
        }


        // Créditos del cliente
        $creditos = $cliente->creditos();


        // El cliente solamente cuenta
        // sus propios datos

        $totalClientes = 1;


        // Créditos activos del cliente

        $creditosActivos = (clone $creditos)
            ->where('estado', 'Activo')
            ->count();


        // Pagos realizados por el cliente

        $pagosRegistrados = \App\Models\Pago::whereHas(
            'credito',
            function ($query) use ($cliente) {

                $query->where(
                    'cliente_id',
                    $cliente->id
                );
            }
        )->count();


        // Saldo pendiente del cliente

        $saldoPendiente = (clone $creditos)
            ->where('saldo', '>', 0)
            ->sum('saldo');


        // Créditos vencidos del cliente

        $creditosVencidos = (clone $creditos)
            ->where('estado', 'Vencido')
            ->count();
    }


    return view(
        'dashboard',
        compact(
            'totalClientes',
            'creditosActivos',
            'pagosRegistrados',
            'saldoPendiente',
            'creditosVencidos'
        )
    );

})
    ->middleware('auth')
    ->name('dashboard');


// ========================================
// CLIENTES
// ========================================


// ----------------------------------------
// Operaciones administrativas
// Solo Administrador
// ----------------------------------------

Route::resource('clientes', ClienteController::class)
    ->only([
        'create',
        'store',
        'edit',
        'update',
        'destroy'
    ])
    ->middleware([
        'auth',
        'role:Administrador'
    ]);


// ----------------------------------------
// Consultar clientes
// Administrador y Usuario
// ----------------------------------------

Route::resource('clientes', ClienteController::class)
    ->only([
        'index',
        'show'
    ])
    ->middleware('auth');


// ========================================
// CRÉDITOS
// ========================================


// ----------------------------------------
// Operaciones administrativas
// Solo Administrador
// ----------------------------------------

Route::resource('creditos', CreditoController::class)
    ->only([
        'create',
        'store',
        'edit',
        'update',
        'destroy'
    ])
    ->middleware([
        'auth',
        'role:Administrador'
    ]);


// ----------------------------------------
// Consultar créditos
// Administrador y Usuario
// ----------------------------------------

Route::resource('creditos', CreditoController::class)
    ->only([
        'index',
        'show'
    ])
    ->middleware('auth');


// ========================================
// PAGOS
// ========================================


// ----------------------------------------
// Administrador y Usuario
// Consultar y registrar pagos
// ----------------------------------------

Route::resource('pagos', PagoController::class)
    ->only([
        'index',
        'create',
        'store',
        'show'
    ])
    ->middleware('auth');


// ----------------------------------------
// Recibo de pago
// ----------------------------------------

Route::get(
    '/pagos/{pago}/recibo',
    [PagoController::class, 'recibo']
)
    ->middleware('auth')
    ->name('pagos.recibo');


// ----------------------------------------
// Edición y eliminación de pagos
// Solo Administrador
// ----------------------------------------

Route::resource('pagos', PagoController::class)
    ->only([
        'edit',
        'update',
        'destroy'
    ])
    ->middleware([
        'auth',
        'role:Administrador'
    ]);