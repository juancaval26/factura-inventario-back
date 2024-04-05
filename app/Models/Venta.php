<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;

class Venta extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['id_factura', 'producto', 'cantidad', 'descripcion', 'valor_unidad',
    'valor_total' , 'devolucion', 'vendedor','fecha'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
