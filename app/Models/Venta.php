<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'venta';
    protected $fillable = [
        'folio',
        'id_cliente',
        'estado_venta',
        'fecha',
        'subtotal',
        'total',
        'total_letras'
    ];
}
