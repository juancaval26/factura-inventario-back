<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    public function store(Request $request)
    {
        $cliente = Cliente::create($request->all());

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no fue creado'], 404);
        }
        return response()->json($cliente, 201);

    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
    
        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
    
        $cliente->update($request->all());
    
        return response()->json($cliente, 200);

    }

    public function destroy($id)
    {
        // Eliminar un cliente de la base de datos
    }

}
