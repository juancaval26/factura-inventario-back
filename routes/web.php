<?php
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
use App\Http\Controllers\RemisionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación  (en api.php)
Route::post('/login', [LoginController::class, 'customLogin'])->name('login');
Route::middleware('cors')->post('api/login', [LoginController::class, 'customLogin'])->name('login');

// Route::middleware(['auth'])->group(function () {
Route::post('api/register', [RegisterController::class, 'customRegister'])->name('register');
Route::middleware('auth:')->post('api/logout', [LoginController::class, 'logout'])->name('logout');

    // Rutas protegidas que requieren autenticación
    // Esta ruta solo será accesible si el usuario está autenticado
Route::resource('api/clientes', ClienteController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('api/clientes/buscar', [ClienteController::class, 'show'])->name('clientes.buscar');
Route::resource('api/devolucion', DevolucionController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('api/devolucion/buscar', [DevolucionController::class, 'show'])->name('devolucion.buscar');

Route::resource('api/entrada', EntradaController::class)->only([
    'index', 'store', 'update', 'destroy'
]);

Route::resource('api/gastos', GastoController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('api/gastos/buscar', [GastoController::class, 'show'])->name('gastos.buscar');
Route::get('api/gastos/total', [GastoController::class, 'GastoFecha'])->name('gastos.total');

Route::resource('api/inventario', InventarioController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('api/inventario/buscar', [InventarioController::class, 'show'])->name('inventario.buscar');

Route::resource('api/productos', ProductoController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('api/productos/buscar', [ProductoController::class, 'show'])->name('productos.buscar');

Route::resource('api/salida', SalidaController::class);

Route::resource('api/ventas', VentaController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('api/ventas/buscar', [VentaController::class, 'show'])->name('ventas.buscar');
Route::get('api/ventas/total', [VentaController::class, 'totalVenta'])->name('ventas.total');
Route::get('api/ventas/pago', [VentaController::class, 'pagoNomina'])->name('ventas.pago');
Route::get('api/ventas/ultimoId', [VentaController::class, 'UltimoIdVentas'])->name('ventas.ultimoId');

Route::resource('api/facturas', FacturaController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('api/facturas/buscar', [FacturaController::class, 'show'])->name('facturas.buscar');
Route::get('api/facturas/detalles', [FacturaController::class, 'detallesFactura'])->name('facturas.detalles');

Route::resource('api/remisiones', RemisionController::class)->only([
    'index', 'store', 'update', 'destroy'
]);
Route::get('api/remisiones/buscar', [RemisionController::class, 'show'])->name('remisiones.buscar');

// });

Auth::routes();

