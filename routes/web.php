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

    $totalClientes = \App\Models\Cliente::where('estado', true)->count();

    $creditosActivos = \App\Models\Credito::where('estado', 'Activo')->count();

    $pagosRegistrados = \App\Models\Pago::count();

    $saldoPendiente = \App\Models\Credito::where('saldo', '>', 0)
        ->sum('saldo');

    $creditosVencidos = \App\Models\Credito::where('estado', 'Vencido')->count();

    return view('dashboard', compact(
        'totalClientes',
        'creditosActivos',
        'pagosRegistrados',
        'saldoPendiente',
        'creditosVencidos'
    ));

})
    ->middleware('auth')
    ->name('dashboard');


// ========================================
// CLIENTES
// ========================================

// Consultar clientes
// Administrador y Usuario pueden consultar.
Route::resource('clientes', ClienteController::class)
    ->only(['index', 'show'])
    ->middleware('auth');


// Operaciones administrativas de clientes
// Solo Administrador.
Route::resource('clientes', ClienteController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'role:Administrador']);


// ========================================
// CRÉDITOS
// ========================================

// Consultar créditos
// Administrador y Usuario pueden consultar.
Route::resource('creditos', CreditoController::class)
    ->only(['index', 'show'])
    ->middleware('auth');


// Operaciones administrativas de créditos
// Solo Administrador.
Route::resource('creditos', CreditoController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'role:Administrador']);

// ========================================
// PAGOS
// ========================================

// Administrador y Usuario pueden consultar y registrar pagos.
Route::resource('pagos', PagoController::class)
    ->only(['index', 'create', 'store', 'show'])
    ->middleware('auth');

// Recibo de pago
Route::get('/pagos/{pago}/recibo', [PagoController::class, 'recibo'])
    ->middleware('auth')
    ->name('pagos.recibo');

// Edición y eliminación de pagos
// Solo Administrador.
Route::resource('pagos', PagoController::class)
    ->only(['edit', 'update', 'destroy'])
    ->middleware(['auth', 'role:Administrador']);