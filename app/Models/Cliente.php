<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;


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

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'id_cliente');
    }
}
