<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;

class Remision extends Model
{
    use HasFactory;
    protected $table = 'remisiones';
    protected $primaryKey = 'id';
    protected $fillable = [
        'codigo',
        'cod_venta',
        'id_cliente',
        'detalles',
        'fecha',    
    ];
    // Desactivar las marcas de tiempo
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
