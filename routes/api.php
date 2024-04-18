<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/clientes', ClienteController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('/clientes/buscar', [ClienteController::class, 'show'])->name('clientes.buscar');

Route::resource('/devolucion', DevolucionController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('/devolucion/buscar', [DevolucionController::class, 'show'])->name('devolucion.buscar');

Route::resource('/entrada', EntradaController::class)->only([
    'index', 'store', 'update', 'destroy'
]);

Route::resource('/gastos', GastoController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('/gastos/buscar', [GastoController::class, 'show'])->name('gastos.buscar');
Route::get('/gastos/total', [GastoController::class, 'GastoFecha'])->name('gastos.total');

Route::resource('/inventario', InventarioController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('/inventario/buscar', [InventarioController::class, 'show'])->name('inventario.buscar');

Route::resource('/productos', ProductoController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('/productos/buscar', [ProductoController::class, 'show'])->name('productos.buscar');

Route::resource('/salida', SalidaController::class);

Route::resource('/ventas', VentaController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('/ventas/buscar', [VentaController::class, 'show'])->name('ventas.buscar');
Route::get('/ventas/total', [VentaController::class, 'totalVenta'])->name('ventas.total');
Route::get('/ventas/pago', [VentaController::class, 'pagoNomina'])->name('ventas.pago');
Route::get('/ventas/ultimoId', [VentaController::class, 'UltimoIdVentas'])->name('ventas.ultimoId');

Route::resource('/facturas', FacturaController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('/facturas/detalles', [FacturaController::class, 'show']);

Auth::routes();