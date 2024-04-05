<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\VentaController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController; 


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/api/clientes', ClienteController::class);
Route::resource('/api/gastos', GastoController::class);
Route::resource('/api/inventario', InventarioController::class);
Route::resource('/api/factura', FacturaController::class);
Route::resource('/api/ventas', VentaController::class);

Auth::routes();

Route::post('/api/register', [RegisterController::class, 'customRegister'])->name('register');
Route::post('/api/login', [LoginController::class, 'customLogin'])->name('customLogin');
