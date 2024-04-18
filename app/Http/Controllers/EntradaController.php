<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entrada;
use Illuminate\Support\Facades\DB;

class EntradaController extends Controller
{
    // Mostrar todas las entradas con su inventario asociado
    public function index()
    {
        $entradas = DB::select("
        SELECT 
            entradas.codigo, entradas.cantidad, entradas.fecha, inventario.codigo, inventario.id_producto,
            productos.nombre, productos.id
        FROM entradas 
            INNER JOIN inventario ON inventario.id = entradas.id_inventario
            INNER JOIN productos ON productos.id = entradas.id_producto
        ");
        return response()->json($entradas);
    }

    // Mostrar una entrada específica con su inventario asociado
    public function show($id)
    {
        $entrada = Entrada::with('inventario')->findOrFail($id);
        return response()->json($entrada);
    }

    // Crear una nueva entrada
    public function store(Request $request)
    {
        $request->validate([
            'id_inventario' => 'required|exists:inventario,id',
            'id_producto' => 'required|exists:productos,id',
            'cantidad' => 'required',
            'codigo' => 'required',
            'fecha' => 'required|date',
        ]);

        $entrada = Entrada::create($request->all());
        return response()->json($entrada, 201);
    }

    // Actualizar una entrada existente
    public function update(Request $request, $id)
    {
        $entrada = Entrada::find($id);
        $entrada->update($request->all());
        return response()->json($entrada, 200);
    }
}