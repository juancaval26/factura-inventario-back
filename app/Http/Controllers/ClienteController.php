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
        // $clientes = Cliente::paginate(10);
        $clientes = DB::table('clientes')->simplePaginate(15);
        return response()->json($clientes);
        
    }

    public function show(Request $request)
    {
        $nit = $request->input('nit');
        $negocio = $request->input('negocio');
        $nombre = $request->input('nombre');
    
        // Inicializar la consulta con el modelo Cliente
        $query = Cliente::query();
    
        // Aplicar condiciones de búsqueda según los parámetros recibidos
        if ($nit) {
            $query->where('nit', 'LIKE', '' . $nit . '%');
        }
    
        if ($negocio) {
            $query->where('negocio', 'LIKE', '' . $negocio . '%');
        }

        if ($nombre) {
            $query->where('nombre', 'LIKE', '' . $nombre . '%');
        }
    
        // Ejecutar la consulta y obtener los resultados
        $clientes = $query->select('id', 'negocio', 'nit', 'nombre')->get();
    
        return response()->json($clientes);
    }
    
    public function store(Request $request)
    {
        // Validar datos de entrada
        // $request->validate([
        //     'id_factura' => 'required',
        //     'id_producto' => 'required',
        //     'cantidad' => 'required',
        //     'codigo' => 'required',
        //     'valor_total' => 'required',
        //     'vendedor' => 'required',
        //     'fecha' => 'required|date'
        // ]);
        
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
