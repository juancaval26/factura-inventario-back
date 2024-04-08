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

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'id_inventario');
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'id_producto');
    }
}
