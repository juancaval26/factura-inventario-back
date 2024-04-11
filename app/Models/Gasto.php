<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;
    protected $table = 'gastos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'articulo',
        'motivo_gasto',
        'valor',
        'fecha'
    ];
}
