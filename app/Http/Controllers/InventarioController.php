<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventario;


class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with('producto')->get();

        return response()->json($inventarios);
    }

    public function show(Request $request, $id)
    {
        try {

            $codigo = $request->input('codigo');
            // Realiza la búsqueda por el código de venta
            $inventario = Inventario::where('codigo', $codigo)->select('id', 'codigo')->get();

            // Verificar si se encontró el producto
            if (!$inventario) {
                // Si el producto no se encuentra, devolver una respuesta de error
                return response()->json(['message' => 'Producto no encontrado'], 404);
            }
    
            // Devolver el producto como respuesta en formato JSON
            return response()->json($inventario);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que ocurra durante la búsqueda
            return response()->json(['message' => 'Error al buscar el producto'], 500);
        }
    }

    public function store(Request $request)
    {
        $inventario = Inventario::create($request->all());
        return response()->json($inventario, 201);

    }

    public function update(Request $request, $id)
    {
        $inventario = Inventario::find($id);
    
        if (!$inventario) {
            return response()->json(['message' => 'Inventario no encontrado'], 404);
        }
    
        $inventario->update($request->all());
    
        return response()->json($inventario, 200);

    }
}
