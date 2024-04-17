<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Venta;


class Devolucion extends Model
{
    use HasFactory;
    protected $table = 'devoluciones';
    protected $primaryKey = 'id';
    protected $fillable = ['id_venta', 'cantidad', 'fecha'];
    // Desactivar las marcas de tiempo
    public $timestamps = false;
    
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }
}
