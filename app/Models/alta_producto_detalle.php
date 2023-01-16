<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alta_producto_detalle extends Model
{
    use HasFactory;
    protected $table = 'alta_producto_detalle';

    protected $fillable = [
        'id_producto',
        'id_alta',
        'cantidad',
        'precio_venta',
        'precio_compra',
        'observaciones'
    ];
}
