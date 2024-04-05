<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventario;


class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::all();
        return response()->json($inventarios);
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
