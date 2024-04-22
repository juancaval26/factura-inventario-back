<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventario;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with('producto')->get();

        return response()->json($inventarios);
    }

    public function show(Request $request)
    {
        try {
            $codigo = $request->input('codigo');
            // Obtener los IDs de los productos desde la consulta
            $ids_productos = explode(',', $request->input('id_producto'));
    
            if (!empty($codigo)) {
                // Consulta por código
                $inventario = DB::select("
                    SELECT 
                        inventario.id, inventario.codigo, inventario.stock
                    FROM inventario 
                    WHERE inventario.codigo = ?
                ", [$codigo]);
    
                if (empty($inventario)) {
                    return response()->json(['message' => 'Producto no encontrado'], 404);
                } else {
                    return response()->json($inventario);
                }
            } elseif (!empty($ids_productos)) {
                // Realizar la consulta para obtener el inventario de los productos solicitados
                $inventario = DB::table('inventario')
                                ->select('id', 'stock', 'id_producto')
                                ->whereIn('id_producto', $ids_productos)
                                ->get();
    
                if ($inventario->isEmpty()) {
                    return response()->json(['message' => 'Producto no encontrado'], 404);
                } else {
                    return response()->json($inventario);
                }
            } else {
                // Si no se proporciona ni 'codigo' ni 'id_producto', devolver un error
                return response()->json(['message' => 'Debe proporcionar el parámetro "codigo" o "id_producto"'], 400);
            }
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al buscar el producto'], 500);
        }
    }
    

    public function store(Request $request)
    {

        // Validar datos de entrada
        $request->validate([
            'codigo' => 'required',
            'id_producto' => 'required',
            'stock' => 'required',
            'fecha' => 'required|date'
        ]);

        $inventario = Inventario::create($request->all());
        if ($inventario) {
            return response()->json($inventario, 201);
        } else {
            return response()->json(['message' => 'Inventario no encontrado'], 404);
        }

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
