<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    // Listar todas las facturas con sus clientes
    public function index()
    {
        $facturas = Factura::with('cliente')->get();
        return response()->json($facturas);
    }

        // Mostrar una devolución específica con sus ventas, facturas y productos asociados
    public function show(Request $request, $id)
    {
        try {

            $codigo = $request->input('codigo');
            // Realiza la búsqueda por el código de venta
            $factura = Factura::where('codigo', $codigo)->select('id', 'codigo')->get();

            // Verificar si se encontró el producto
            if (!$factura) {
                // Si el producto no se encuentra, devolver una respuesta de error
                return response()->json(['message' => 'Producto no encontrado'], 404);
            }
    
            // Devolver el producto como respuesta en formato JSON
            return response()->json($factura);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que ocurra durante la búsqueda
            return response()->json(['message' => 'Error al buscar el producto'], 500);
        }
    }

    // Crear una nueva factura para un cliente dado
    public function store(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'codigo' => 'required|unique:facturas,codigo',
            'fecha' => 'required|date',
        ]);

        // Obtener el ID del cliente desde la solicitud
        $clienteId = $request->input('id_cliente');

        // Crear la factura asociada al cliente
        $factura = new Factura();
        $factura->id_cliente = $clienteId;

        $factura->codigo = $request->input('codigo');
        $factura->fecha = $request->input('fecha');
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

        // Validar datos de entrada si es necesario
        $request->validate([
            'codigo' => 'required|unique:facturas,codigo,'.$id,
            'fecha' => 'required|date',
        ]);

        // Actualizar la factura con los datos proporcionados
        $factura->update($request->all());

        return response()->json($factura, 200);
    }
}
