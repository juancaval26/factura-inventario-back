<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salida;
use Illuminate\Support\Facades\DB;


class SalidaController extends Controller
{

    public function index()
    {
        $salidas = DB::select("
        SELECT 
            productos.nombre nom_producto,
            salidas.id id_salida, salidas.codigo cod_salida, salidas.fecha fecha_salida,
            salidas.motivo, ventas.id id_venta, ventas.cantidad cant_ventas, ventas.vendedor,
            inventario.id id_inventario, inventario.codigo cod_inventario
        FROM salidas
            INNER JOIN ventas ON ventas.id = salidas.id_venta
            INNER JOIN productos ON productos.id = ventas.id_producto
            INNER JOIN inventario ON inventario.id = salidas.id_inventario
        ");
    
        return response()->json($salidas);
    }

    // Mostrar una salida específica con su inventario y ventas asociadas
    public function show($id)
    {
        $salida = Salida::with('inventario', 'venta')->findOrFail($id);
        return response()->json($salida);
    }

    // Crear una nueva salida
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'motivo' => 'required',
            'id_venta' => 'required',
            'id_inventario' => 'required',
            'fecha' => 'required',
        ]);

        $salida = Salida::create($request->all());
        return response()->json($salida, 201);
    }

    // Actualizar una salida existente
    public function update(Request $request, $id)
    {
        $salida = Salida::findOrFail($id);
        $salida->update($request->all());
        return response()->json($salida, 200);
    }
}