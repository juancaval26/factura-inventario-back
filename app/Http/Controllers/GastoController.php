<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gasto;


class GastoController extends Controller
{
    public function index()
    {
        $gastos = Gasto::all();
        return response()->json($gastos);
    }

    public function store(Request $request)
    {
        $gasto = Gasto::create($request->all());
        return response()->json($gasto, 201);

    }

    public function update(Request $request, $id)
    {
        $gasto = Gasto::find($id);
    
        if (!$gasto) {
            return response()->json(['message' => 'Gasto no encontrado'], 404);
        }
    
        $gasto->update($request->all());
    
        return response()->json($gasto, 200);

    }
}
