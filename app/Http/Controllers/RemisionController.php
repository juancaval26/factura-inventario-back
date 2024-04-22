<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Remision;
use Illuminate\Support\Facades\DB;

class RemisionController extends Controller
{
    public function index()
    {
        //no quitar los as cuando se use este tipo de consulta, dara error
        $remisiones = Remision::with('cliente:id,nombre')->select('id', 'id_cliente', 'codigo', 'cod_venta', 'detalles', 'fecha')
        ->orderBy('id_cliente')  // Ordenar por el campo 'nombre'
        ->simplePaginate(15);
        return response()->json($remisiones);
    }

    public function store(Request $request)
    {
        // Validar datos de remision
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'detalles' => 'required',
            'fecha' => 'required|date',
        ]);
        
        $remision = Remision::create($request->all());

        if (!$remision) {
            return response()->json(['message' => 'remision no fue creada'], 404);
        }
        return response()->json($remision, 201);
    }

    public function show(Request $request)
    {
        // Obtener los parámetros de búsqueda desde la solicitud
        $cliente = $request->input('nombre');
        $query = Remision::query();

        if ($cliente) {
            // Filtrar por nombre del cliente
            $query->whereHas('cliente', function ($query) use ($cliente) {
                $query->where('nombre', 'like', '%' . $cliente . '%');
            });
        }
        
        $remisiones = $query->with('cliente:id,nombre')->select('id', 'id_cliente', 'codigo', 'cod_venta', 'detalles', 'fecha')->get();
        
        if ($remisiones->isEmpty()) {
            return response()->json(['message' => 'No se encontraron remisiones'], 404);
        } else {
            return response()->json($remisiones);
        }
        
    }

    public function update(Request $request, $id)
    {
        $remision = Remision::find($id);
    
        if (!$remision) {
            return response()->json(['message' => 'Remisión no encontrado'], 404);
        }
    
        $remision->update($request->all());
    
        return response()->json($remision, 200);
    }

    public function destroy($id)
    {
        try {
            // Buscar la remisión por su ID
            $remision = Remision::find($id);
            
            // Eliminar la remisión
            $remision->delete();
    
            // Si se llega hasta aquí, la remisión se ha eliminado correctamente
            return response()->json(['message' => 'Remisión eliminada correctamente'], 200);
        } catch (\Exception $e) {
            // Si ocurre un error, devolver un mensaje de error
            return response()->json(['message' => 'Error al eliminar la remisión: ' . $e->getMessage()], 500);
        }
    }
    
}
