<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Venta;

class Factura extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [ 'id_venta', 'codigo', 'fecha'];

    // Desactivar las marcas de tiempo
    public $timestamps = false;
    
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }
}
