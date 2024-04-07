<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\VentaController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController; 


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/clientes', ClienteController::class);
Route::get('/clientes/buscar', [VentaController::class, 'show']);
Route::resource('/devolucion', DevolucionController::class);
Route::resource('/entrada', EntradaController::class);
Route::resource('/factura', FacturaController::class);
Route::get('/factura/buscar', [InventarioController::class, 'show']);
Route::resource('/gastos', GastoController::class);
Route::resource('/inventario', InventarioController::class);
Route::get('/inventario/buscar', [InventarioController::class, 'show']);
Route::resource('/productos', ProductoController::class);
Route::get('/productos/buscar', [ProductoController::class, 'show']);
Route::resource('/salida', SalidaController::class);
Route::resource('/ventas', VentaController::class);
Route::get('/ventas/buscar', [VentaController::class, 'show']);

Auth::routes();

Route::post('/register', [RegisterController::class, 'customRegister'])->name('register');
Route::post('/login', [LoginController::class, 'customLogin'])->name('customLogin');