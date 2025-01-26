<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    
    protected $table = 'detalle_ventas';
    protected $fillable = [
        'venta_id',
        'producto_almacen_id',
        'cantidad',
        'precio_venta',
    ];
}
