<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Venta;


class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'negocio',
        'direccion',
        'telefono',
        'nit',
        'estado',
        'correo'
    ];
        // Desactivar las marcas de tiempo
        public $timestamps = false;

    public function venta()
    {
        return $this->hasMany(Venta::class, 'id_cliente');
    }
}
