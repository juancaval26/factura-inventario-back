<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\venta;


class VentaController extends Controller
{
        // Listar todas las venta con sus clientes
        public function index()
        {
            $venta = Venta::with('factura')->get();
            return response()->json($venta);
        }

        public function show(Request $request)
        {
            $codigo = $request->input('codigo');
    
            // Realiza la búsqueda por el código de venta
            $ventas = Venta::where('codigo', $codigo)->select('id', 'codigo')->get();
    
            return response()->json($ventas);
        }
    
        // Crear una nueva venta para un cliente dado
        public function store(Request $request)
        {
            // Validar datos de entrada
            $request->validate([
                'id_factura' => 'required|exists:facturas,id',
                'id_producto' => 'required|unique:productos,id',
                'codigo' => 'required|unique:venta,codigo',
                'cantidad' => 'required|unique:venta,cantidad',
                'descripcion' => 'required|unique:venta,descripcion',
                'valor_unidad' => 'required|unique:venta,valor_unidad',
                'valor_total' => 'required|unique:venta,valor_total',
                'devolucion' => 'required|unique:venta,devolucion',
                'vendedor' => 'required|unique:venta,vendedor',
                'fecha' => 'required|date'
            ]);
    
            // Obtener el ID del cliente desde la solicitud
            $facturaId = $request->input('id_factura');
    
            // Crear la venta asociada al cliente
            $venta = new Venta();
            $venta->id_factura = $facturaId;
            $venta->codigo = $request->input('id_producto');
            $venta->fecha = $request->input('cantidad');
            $venta->fecha = $request->input('codigo');
            $venta->fecha = $request->input('descripcion');
            $venta->fecha = $request->input('valor_unidad');
            $venta->fecha = $request->input('valor_total');
            $venta->fecha = $request->input('devolucion');
            $venta->fecha = $request->input('vendedor');
            $venta->fecha = $request->input('fecha');

            // Asignar otros campos de la venta desde la solicitud si es necesario
            $venta->save();
    
            return response()->json($venta, 201);
        }
    
        // Actualizar los detalles de una venta existente
        public function update(Request $request, $id)
        {
            // Buscar la venta por ID
            $venta = Venta::find($id);
    
            // Verificar si la venta existe
            if (!$venta) {
                return response()->json(['message' => 'venta no encontrada'], 404);
            }
    
            // Validar datos de entrada si es necesario
            $request->validate([
                'id_factura' => 'required|exists:facturas,id'.$id,
                'id_producto' => 'required|unique:productos,id',
                'cantidad' => 'required|unique:venta,cantidad',
                'codigo' => 'required|unique:venta,codigo',
                'descripcion' => 'required|unique:venta,descripcion',
                'valor_unidad' => 'required|unique:venta,valor_unidad',
                'valor_total' => 'required|unique:venta,valor_total',
                'devolucion' => 'required|unique:venta,devolucion',
                'vendedor' => 'required|unique:venta,vendedor',
                'fecha' => 'required|date'
            ]);
    
            // Actualizar la venta con los datos proporcionados
            $venta->update($request->all());
    
            return response()->json($venta, 200);
        }
}
