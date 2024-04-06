<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::all();
        return response()->json($productos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {

            $nombre = $request->input('nombre');
            // Realiza la búsqueda por el código de venta
            $producto = Producto::where('nombre', $nombre)->select('id', 'nombre')->get();

            // Verificar si se encontró el producto
            if (!$producto) {
                // Si el producto no se encuentra, devolver una respuesta de error
                return response()->json(['message' => 'Producto no encontrado'], 404);
            }
    
            // Devolver el producto como respuesta en formato JSON
            return response()->json($producto);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que ocurra durante la búsqueda
            return response()->json(['message' => 'Error al buscar el producto'], 500);
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
    
        if (!$producto) {
            return response()->json(['message' => 'Gasto no encontrado'], 404);
        }
    
        $producto->update($request->all());
    
        return response()->json($producto, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
