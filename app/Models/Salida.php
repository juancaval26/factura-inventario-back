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
    protected $fillable = ['id_inventario', 'codigo', 'motivo', 'id_venta', 'fecha'];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'id_inventario');
    }

    public function ventas()
    {
        return $this->belongsTo(Venta::class, 'id');
    }
}
