<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Venta;

class Factura extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'facturas';
    protected $fillable = [ 'id_venta', 'codigo'];

    // Desactivar las marcas de tiempo
    public $timestamps = false;

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }
}
