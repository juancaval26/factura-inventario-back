<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;


class ClienteController extends Controller
{
    public function index()
    {
        $clientes = DB::table('clientes')
        ->select('id', 'nombre', 'negocio', 'direccion', 'telefono', 'nit', 'estado', 'correo')
        ->orderBy('nombre')  // Ordenar por el campo 'nombre'
        ->simplePaginate(15);
        return response()->json($clientes);
        
    }

    public function show(Request $request)
    {
        $nombre = $request->input('nombre');
    
        // Inicializar la consulta con el modelo Cliente
        $query = Cliente::query();
    
        // Aplicar condiciones de búsqueda según los parámetros recibidos
        if ($nombre) {
            $query->where('nombre', 'LIKE', '%' . $nombre . '%');
        }
    
        // Ejecutar la consulta y obtener los resultados
        $clientes = $query->select('id', 'nombre', 'negocio', 'direccion', 'telefono', 'nit', 'estado', 'correo')->get();
    
        return response()->json($clientes);
    }
    
    public function store(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'nombre' => 'required',
            'negocio' => 'required',
            // 'direccion' => 'required',
            'telefono' => 'required',
        ]);
        
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
