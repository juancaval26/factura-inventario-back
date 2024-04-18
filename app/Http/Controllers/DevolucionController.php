<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devolucion;
use Illuminate\Support\Facades\DB;

class DevolucionController extends Controller
{
    // Mostrar todas las devoluciones con sus ventas y productos asociados
    public function index()
    {
        $devoluciones = DB::select("
        SELECT 
            ventas.id id_venta, ventas.codigo cod_venta, ventas.descripcion, 
            ventas.vendedor, ventas.fecha fecha_venta,clientes.id id_cliente, 
            clientes.nombre nom_cliente, clientes.negocio, productos.id id_producto, 
            productos.nombre nom_producto,devoluciones.fecha fecha_devolucion,
            devoluciones.cantidad cant_devuelta
        FROM devoluciones
            INNER JOIN ventas ON ventas.id = devoluciones.id_venta
            INNER JOIN clientes ON clientes.id = ventas.id_cliente
            INNER JOIN productos ON productos.id  = ventas.id_producto 
        ");
        return response()->json($devoluciones);
    }

    // Mostrar una devolución específica con sus ventas y productos asociados
    public function show($id)
    {
        $devolucion = Devolucion::with('venta.cliente', 'venta.producto')->findOrFail($id);
        return response()->json($devolucion);
    }

    // Crear una nueva devolución
    public function store(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'id_venta' => 'required|exists:ventas,id',
            'fecha' => 'required|date',
            'cantidad' => 'required'
        ]);
        $devolucion = Devolucion::create($request->all());
        return response()->json($devolucion, 201);
    }

    // Actualizar una devolución existente
    public function update(Request $request, $id)
    {
        $devolucion = Devolucion::findOrFail($id);

        if (!$devolucion) {
            return response()->json(['message' => 'devolucion no encontrada'], 404);
        }

        $devolucion->update($request->all());
        return response()->json($devolucion, 200);
    }
}
