<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventario;
use App\Models\Producto;


class Entrada extends Model
{
    use HasFactory;
    protected $table = 'entradas';
    protected $primaryKey = 'id';
    protected $fillable = ['id_inventario', 'codigo', 'id_producto', 'cantidad', 'fecha'];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'id_inventario');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_inventario');
    }
}
