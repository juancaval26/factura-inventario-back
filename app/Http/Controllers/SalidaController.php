<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salida;


class SalidaController extends Controller
{
    // Mostrar todas las salidas con su inventario y ventas asociadas
    public function index()
    {
        $salidas = Salida::with('inventario', 'ventas')->get();
        return response()->json($salidas);
    }

    // Mostrar una salida específica con su inventario y ventas asociadas
    public function show($id)
    {
        $salida = Salida::with('inventario', 'ventas')->findOrFail($id);
        return response()->json($salida);
    }

    // Crear una nueva salida
    public function store(Request $request)
    {
        $request->validate([
            'id_inventario' => 'required',
            'codigo' => 'required',
            'id_venta' => 'required',
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