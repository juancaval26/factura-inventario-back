<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;
use App\Models\Devolucion;
use App\Models\Salida;



class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    protected $fillable = ['id_factura', 'id_producto', 'cantidad', 'codigo', 'descripcion',
    'valor_total' , 'devolucion', 'vendedor','fecha'];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

    public function cliente()
    {
        return $this->belongsTo(Factura::class, 'id_cliente');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function devoluciones()
    {
        return $this->hasMany(Devolucion::class, 'id_venta');
    }

    public function salidas()
    {
        return $this->hasMany(Salida::class, 'id_venta');
    }
}
