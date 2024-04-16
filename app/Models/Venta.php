<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Devolucion;
use App\Models\Salida;
use App\Models\Factura;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    protected $fillable = ['id_producto','id_cliente', 'cantidad', 'codigo', 'descripcion',
    'precio', 'vendedor','fecha'];

    public function cliente()
    {
        return $this->hasMany(Cliente::class, 'id_cliente');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function devolucion()
    {
        return $this->hasMany(Devolucion::class, 'id_venta');
    }

    public function salida()
    {
        return $this->hasMany(Salida::class, 'id_salida');
    }

    public function factura()
    {
        return $this->hasMany(Factura::class, 'id_venta');
    }
}
