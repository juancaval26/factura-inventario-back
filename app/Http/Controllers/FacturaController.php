<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Factura;
use App\Models\Venta;


class FacturaController extends Controller
{

    public function index()
    {
        //no quitar los as cuando se use este tipo de consulta, dara error
        $facturas = DB::table(function ($query) {
            $query->select(
                'facturas.id','facturas.codigo','ventas.vendedor','ventas.fecha',
                'clientes.nombre as nom_cliente','clientes.negocio','clientes.direccion',
                'clientes.telefono','clientes.correo',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY facturas.codigo ORDER BY clientes.nombre) AS row_num')
            )
            ->from('facturas')
            ->join('ventas', 'ventas.id', '=', 'facturas.id_venta')
            ->join('clientes', 'clientes.id', '=', 'ventas.id_cliente');
        }, 'subquery')
        ->where('row_num', '=', 1)
        ->orderBy('nom_cliente')
        ->simplePaginate(15);
    
        return response()->json($facturas);
    }
    
    //buscador
    public function show(Request $request)
    {
        try {
            $codigo = '%'.$request->input('codigo').'%';
            $facturas = DB::select("
            SELECT 
                facturas.id id_fac, facturas.codigo, ventas.vendedor, ventas.fecha, clientes.id id_cli, 
                clientes.nombre nom_cliente,clientes.negocio, clientes.direccion, clientes.telefono
            FROM facturas 
                INNER JOIN ventas ON ventas.id = facturas.id_venta
                INNER JOIN clientes ON clientes.id = ventas.id_cliente
            WHERE facturas.codigo like ?",[$codigo]);
            if ($facturas) {
                return response()->json($facturas);
            } else {
                return response()->json(['message' => 'No se encontraron facturas'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la solicitud: ' . $e->getMessage()], 500);
        }
    }

    public function detallesFactura(Request $request)
    {
        $codigo = $request->input('codigo');
    
        // Obtener los detalles únicos de la factura
        $facturaEnc = Factura::select(
                'facturas.codigo',
                'ventas.fecha',
                'clientes.nombre as nom_cliente',
                'clientes.negocio',
                'clientes.direccion',
                'clientes.telefono',
                'ventas.vendedor',   
            )
            ->join('ventas', 'facturas.id_venta', '=', 'ventas.id')
            ->join('clientes', 'ventas.id_cliente', '=', 'clientes.id')
            ->where('facturas.codigo', $codigo)
            ->first();
    
        // Obtener los detalles de los productos asociados a la venta
        $facturaDet = Venta::select(
                'productos.nombre as nom_producto',
                'ventas.cantidad',
                'ventas.precio',
                DB::raw('SUM(ventas.cantidad * ventas.precio) as total_producto')

            )
            ->join('facturas', 'facturas.id_venta', '=', 'ventas.id')
            ->join('productos', 'productos.id', '=', 'ventas.id_producto')
            ->where('facturas.codigo', $facturaEnc->codigo)
            ->groupBy('productos.nombre', 'ventas.cantidad', 'ventas.precio')
            ->get();
    
        return response()->json([
            'facturaEnc' => $facturaEnc,
            'facturaDet' => $facturaDet
        ]);
    }
    
        // Crear una nueva factura para un cliente dado
        public function store(Request $request)
        {
        try {

            // Validar datos de entrada
            $request->validate([
                '*.id_venta' => 'required|exists:ventas,id',
                '*.codigo' => 'required',
            ]);

            $facturasData = $request->all();
            $facturasGuardadas = [];

            foreach ($facturasData as $facturaData) {
                $factura = new Factura();
                $factura->id_venta = $facturaData['id_venta'];
                $factura->codigo = $facturaData['codigo'];                
                
                // Guardar la factura
                $factura->save();
                // Agregar la factura guardada al arreglo de facturas guardadas
                $facturasGuardadas[] = $factura;
            }   
            return response()->json($factura, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        }

           // Actualizar los detalles de una factura existente
    public function update(Request $request, $id)
    {
        // Buscar la factura por ID
        $factura = Factura::find($id);

        // Verificar si la factura existe
        if (!$factura) {
            return response()->json(['message' => 'Factura no encontrada'], 404);
        }

        // Actualizar la factura con los datos proporcionados
        $factura->update($request->all());
        return response()->json($factura, 200);
    }
}
