<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;


class FacturaController extends Controller
{
    public function index()
    {
        $facturas = DB::select("
        SELECT 
            codigo,vendedor,fecha,nom_cliente,negocio,direccion,telefono,correo
    FROM (
        SELECT 
            facturas.codigo,ventas.vendedor,ventas.fecha,clientes.nombre nom_cliente,
            clientes.negocio,clientes.direccion,clientes.telefono,clientes.correo,
            ROW_NUMBER() OVER (PARTITION BY facturas.codigo ORDER BY clientes.nombre) row_num
        FROM facturas 
            INNER JOIN ventas ON ventas.id = facturas.id_venta
            INNER JOIN productos ON productos.id = ventas.id_producto
            INNER JOIN clientes ON clientes.id = facturas.id_cliente
    ) AS subquery
    WHERE row_num = 1");

        return response()->json($facturas);
    }

    public function show(Request $request)
    {

    }

        // Crear una nueva factura para un cliente dado
        public function store(Request $request)
        {
            // Validar datos de entrada
            $request->validate([
                'id_cliente' => 'required|exists:clientes,id',
                'id_venta' => 'required|exists:ventas,id',
                'codigo' => 'required',
            ]);
    
            // Obtener el ID del cliente desde la solicitud
            $clienteId = $request->input('id_cliente');
            $ventaId = $request->input('id_venta');
    
            // Crear la factura asociada al cliente
            $factura = new Factura();
            $factura->id_cliente = $clienteId;
            $factura->id_venta = $ventaId;
            $factura->codigo = $request->input('codigo');
            // Asignar otros campos de la factura desde la solicitud si es necesario
            $factura->save();
    
            return response()->json($factura, 201);
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
