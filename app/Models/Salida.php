<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventario;
use App\Models\Venta;

class Salida extends Model
{
    use HasFactory;
    protected $table = 'salidas';
    protected $primaryKey = 'id';
    protected $fillable = ['id_inventario', 'id_venta', 'codigo', 'motivo',  'fecha'];
    // Desactivar las marcas de tiempo
    public $timestamps = false;
    
    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'id_inventario');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }
}
