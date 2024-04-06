<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entrada;

class EntradaController extends Controller
{
    // Mostrar todas las entradas con su inventario asociado
    public function index()
    {
        $entradas = Entrada::with('inventario.producto')->get();
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
            'id_inventario' => 'required',
            'codigo' => 'required',
            'id_producto' => 'required',
            'cantidad' => 'required',
            'fecha' => 'required',
        ]);

        $entrada = Entrada::create($request->all());
        return response()->json($entrada, 201);
    }

    // Actualizar una entrada existente
    public function update(Request $request, $id)
    {
        $entrada = Entrada::findOrFail($id);
        $entrada->update($request->all());
        return response()->json($entrada, 200);
    }
}