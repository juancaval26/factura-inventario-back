<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devolucion;

class DevolucionController extends Controller
{
    // Mostrar todas las devoluciones con sus ventas, facturas y productos asociados
    public function index()
    {
        $devoluciones = Devolucion::with('venta.factura.cliente', 'venta.producto')->get();
        return response()->json($devoluciones);
    }

    // Mostrar una devolución específica con sus ventas, facturas y productos asociados
    public function show($id)
    {
        $devolucion = Devolucion::with('venta.factura.cliente', 'venta.producto')->findOrFail($id);
        return response()->json($devolucion);
    }

    // Crear una nueva devolución
    public function store(Request $request)
    {
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
