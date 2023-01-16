<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $table = 'inventario';

    protected $fillable = [
      'id_producto',
        'id_alta',
        'existencia',
        'precio_venta',
        'precio_compra',
        'observaciones'
    ];

}
