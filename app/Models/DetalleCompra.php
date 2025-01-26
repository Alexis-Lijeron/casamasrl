<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;
    
    protected $table = 'detalle_compras';
    protected $fillable = [
        'compra_id',
        'producto_almacen_id',
        'cantidad',
        'precio_compra',
    ];
}
