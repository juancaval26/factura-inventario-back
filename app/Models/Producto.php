<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entrada;
use App\Models\Inventario;


class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'descripcion',
        'peso',
        'precio_costo',
        'fecha',
    ];
    // Desactivar las marcas de tiempo
    public $timestamps = false;
    
    public function entrada()
    {
        return $this->hasMany(Entrada::class, 'id_inventario');
    }

    public function inventario()
    {
        return $this->hasMany(Inventario::class, 'id_producto');
    }
}
