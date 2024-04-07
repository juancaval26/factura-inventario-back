<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\venta;
use Illuminate\Support\Facades\DB;



class VentaController extends Controller
{
        // Listar todas las venta con sus clientes
        public function index()
        {
            $ventas = DB::select("
            SELECT 
            ventas.id id_venta, ventas.cantidad, ventas.codigo cod_venta, ventas.descripcion, ventas.valor_total,  		ventas.devolucion, ventas.vendedor, ventas.fecha fecha_venta, facturas.id id_factura, 
            facturas.codigo cod_factura, facturas.fecha elab_factura, clientes.id id_cliente, 
            clientes.nombre nom_cliente, clientes.negocio, productos.id id_producto, 
            productos.nombre nom_producto, productos.precio
        FROM ventas
            INNER JOIN facturas ON facturas.id = ventas.id_factura
            INNER JOIN clientes ON clientes.id = facturas.id_cliente
            INNER JOIN productos ON productos.id  = ventas.id_producto
            ");

            return response()->json($ventas);
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
                'id_factura' => 'required',
                'id_producto' => 'required',
                'cantidad' => 'required',
                'codigo' => 'required',
                'valor_total' => 'required',
                'vendedor' => 'required',
                'fecha' => 'required|date'
            ]);
    
            // Obtener el ID del cliente desde la solicitud
            $facturaId = $request->input('id_factura');
    
            // Crear la venta asociada al cliente
            $venta = new Venta();
            $venta->id_factura = $facturaId;
            $venta->id_producto = $request->input('id_producto');
            $venta->cantidad = $request->input('cantidad');
            $venta->codigo = $request->input('codigo');
            $venta->descripcion = $request->input('descripcion');
            $venta->valor_total = $request->input('valor_total');
            $venta->devolucion = $request->input('devolucion');
            $venta->vendedor = $request->input('vendedor');
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
    
            // Actualizar la venta con los datos proporcionados
            $venta->update($request->all());
    
            return response()->json($venta, 200);
        }
}
