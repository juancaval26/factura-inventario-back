<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entrada;
use App\Models\Salida;
use App\Models\Producto;

class Inventario extends Model
{
    use HasFactory;
    protected $table = 'inventario';
    protected $primaryKey = 'id';
    protected $fillable = [
        'codigo', 
        'id_producto', 
        'stock',
        'fecha',
    ];

    public function entrada()
    {
        return $this->hasMany(Entrada::class, 'id_inventario');
    }

    public function salida()
    {
        return $this->hasMany(Salida::class, 'id_inventario');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
