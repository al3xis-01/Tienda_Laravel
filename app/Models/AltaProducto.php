<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AltaProducto extends Model
{
    use HasFactory;
    protected $fillable = [
      'folio',
        'fecha',
        'motivo',
        'id_proveedor',
        'descuento',
        'subtotal',
        'total',
    ];
    protected $table = 'alta_producto';
}
