<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;


class Factura extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id';
    protected $fillable = ['id_cliente', 'codigo', 'fecha'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
