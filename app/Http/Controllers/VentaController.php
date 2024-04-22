<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;

class VentaController extends Controller
{
        // Listar todas las ventas con sus clientes
        public function index()
        {
            $ventas = DB::select("
            SELECT 
                ventas.id id_venta, ventas.cantidad, ventas.precio, ventas.codigo cod_venta, ventas.descripcion, 			  
                ventas.vendedor, ventas.fecha fecha_venta, clientes.id id_cliente, 
                clientes.nombre nom_cliente, clientes.negocio, productos.id id_producto, 
                productos.nombre nom_producto, (ventas.cantidad * ventas.precio) valor_total       
             FROM ventas
                INNER JOIN clientes ON clientes.id = ventas.id_cliente
                INNER JOIN productos ON productos.id  = ventas.id_producto
            ");

            return response()->json($ventas);
        }

        public function UltimoIdVentas()
        {
            $id = DB::select("
                SELECT MAX(id) id FROM ventas
            ");
            return response()->json($id);
        }

        public function show(Request $request)
        {
            $codigo = $request->input('codigo');
    
            // Realiza la búsqueda por el código de venta
            $ventas = Venta::where('codigo', $codigo)->select('id', 'codigo')->get();
            if ($ventas) {
                return response()->json($ventas);
            }else {
                return response()->json(['message' => 'No se encontraron facturas'], 404);
            }
        }

        public function totalVenta(Request $request)
        {

            $fechaInicial = $request->input('fechaInicial');
            $fechaFinal = $request->input('fechaFinal');

            $pagoFecha = DB::select("
            SELECT
            ventas.id id_venta,
            ventas.vendedor vendedor,
            SUM(ventas.precio * ventas.cantidad) valor_total,
            SUM(productos.precio_costo * ventas.cantidad) total_costo,
            SUM(ventas.cantidad) * SUM(ventas.precio) - SUM(productos.precio_costo * ventas.cantidad) ganancia,
            SUM(((ventas.cantidad * ventas.precio) - (productos.precio_costo * ventas.cantidad)) * 0.4) ganancia_40,
            SUM(((ventas.cantidad * ventas.precio) - (productos.precio_costo * ventas.cantidad)) * 0.6) ganancia_60
        FROM
            ventas
        INNER JOIN
            clientes ON clientes.id = ventas.id_cliente
        INNER JOIN
            productos ON productos.id  = ventas.id_producto
        WHERE
            ventas.fecha BETWEEN ? AND ?
        GROUP BY
            ventas.id, ventas.vendedor
        
            ",[$fechaInicial, $fechaFinal]);

            return response()->json($pagoFecha);
        }

        public function pagoNomina(Request $request)
        {

            $fechaInicial = $request->input('fechaInicial');
            $fechaFinal = $request->input('fechaFinal');

            $pagoFecha = DB::select("
            SELECT MAX(id) id,
            SUM(valor_total) valor_total,
            SUM(total_costo) costo_total,
            SUM(ganancia) ganancia_final,
            SUM(ganancia_40) ganancia_total_40,
            SUM(ganancia_60) ganancia_total_60
        FROM (
            SELECT
                v.id,
                v.vendedor,
                SUM(v.precio * v.cantidad) valor_total,
                SUM(p.precio_costo * v.cantidad) total_costo,
                SUM(v.cantidad) * SUM(v.precio) - SUM(p.precio_costo * v.cantidad) ganancia,
                SUM(((v.cantidad * v.precio) - (p.precio_costo * v.cantidad)) * 0.4) ganancia_40,
                SUM(((v.cantidad * v.precio) - (p.precio_costo * v.cantidad)) * 0.6) ganancia_60
            FROM
                ventas v
            INNER JOIN
                clientes c ON c.id = v.id
            INNER JOIN
                productos p ON p.id  = v.id_producto
            WHERE
                v.fecha BETWEEN ? AND ?
            GROUP BY
                v.id, v.vendedor
        ) total_pago
            ",[$fechaInicial, $fechaFinal]);

            return response()->json($pagoFecha);
        }
    
        public function store(Request $request)
{
    try {
        // Validar datos de entrada para cada venta en el arreglo
        $request->validate([
            '*.id_cliente' => 'required|exists:clientes,id',
            '*.id_producto' => 'required|exists:productos,id',
            '*.cantidad' => 'required',
            '*.precio' => 'required',
            '*.vendedor' => 'required',
            '*.fecha' => 'required|date'
        ]);

        $ventasData = $request->all();
        $ventasGuardadas = [];

        foreach ($ventasData as $ventaData) {
            $venta = new Venta();
            $venta->id_cliente = $ventaData['id_cliente'];
            $venta->id_producto = $ventaData['id_producto'];
            $venta->cantidad = $ventaData['cantidad'];
            $venta->codigo = $ventaData['codigo'];
            $venta->descripcion = $ventaData['descripcion'] ?? null;
            $venta->precio = $ventaData['precio'];
            $venta->vendedor = $ventaData['vendedor'];
            $venta->fecha = $ventaData['fecha'];

            // Puedes agregar otros campos de la venta aquí si es necesario

            // Guardar la venta
            $venta->save();

            // Agregar la venta guardada al arreglo de ventas guardadas
            $ventasGuardadas[] = $venta;
        }

        return response()->json($ventasGuardadas, 201);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
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
