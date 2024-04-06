<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;
    protected $table = 'salidas';
    protected $primaryKey = 'id';
    protected $fillable = ['id_inventario', 'codigo', 'id_venta', 'fecha'];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'id_inventario');
    }

    public function ventas()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }
}
