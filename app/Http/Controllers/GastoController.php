<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gasto;
use Illuminate\Support\Facades\DB;



class GastoController extends Controller
{
    public function index()
    {
        $gastos = DB::table('gastos')
        ->select('id', 'articulo', 'motivo_gasto', 'valor', 'fecha')
        ->orderBy('articulo')  // Ordenar por el campo 'articulo'
        ->simplePaginate(15);
        return response()->json($gastos);
    }

    public function show(Request $request)
    {
        $articulo = $request->input('articulo');
    
        // Inicializar la consulta con el modelo Cliente
        $query = Gasto::query();
    
        // Aplicar condiciones de búsqueda según los parámetros recibidos
        $query->where('articulo', 'LIKE', '' . $articulo . '%');

        // Ejecutar la consulta y obtener los resultados
        $gasto = $query->select('id', 'articulo', 'motivo_gasto', 'valor', 'fecha')->get();
        if ($gasto) {
            return response()->json($gasto);
        } else {
            return response()->json(['message' => 'No se encontraron gasto'], 404);
        }
    }

    public function GastoFecha(Request $request)
    {

        $fechaInicial = $request->input('fechaInicial');
        $fechaFinal = $request->input('fechaFinal');

        $gastoFecha = DB::select("
        SELECT 
            MAX(id) id,
            SUM(valor) gasto_total
        FROM(
            SELECT  
                gastos.id id,
                gastos.valor valor
            FROM gastos
            WHERE gastos.fecha BETWEEN ? AND ?
            ) gasto
        ",[$fechaInicial, $fechaFinal]);

        return response()->json($gastoFecha);
    }

    public function store(Request $request)
    {
        // // Validar datos de entrada
        $request->validate([
            'articulo' => 'required',
            'motivo_gasto' => 'required',
            'valor' => 'required',
            'fecha' => 'required'
        ]);
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
