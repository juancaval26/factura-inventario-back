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
    try {

        $request->validate([
            '*.id_venta' => 'required|exists:ventas,id',
            '*.id_inventario' => 'required|exists:inventario,id',
            '*.codigo' => 'required',
            '*.motivo' => 'required',
            '*.fecha' => 'required|date',
        ]);
                
        $salidasData = $request->all();
        $salidasGuardadas = [];
        
        foreach ($salidasData as $salidaData) {
            $salida = new Salida();
            $salida->id_inventario = $salidaData['id_inventario'];
            $salida->id_venta = $salidaData['id_venta'];
            $salida->codigo = $salidaData['codigo'];
            $salida->motivo = $salidaData['motivo'];
            $salida->fecha = $salidaData['fecha'];                
            
            // Guardar la salida
            $salida->save();
            // Agregar la salida guardada al arreglo de salidas guardadas
            $salidasGuardadas[] = $salida;
        }

        return response()->json($salidasGuardadas, 201);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    // Actualizar una salida existente
    public function update(Request $request, $id)
    {
        $salida = Salida::find($id);
        if (!$salida) {
            return response()->json(['message' => 'Salida no encontrada'], 404);
        } 
        
        $salida->update($request->all());
        return response()->json($salida, 200);
    }
}