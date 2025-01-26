<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleDevolucion extends Model
{
    use HasFactory;
    
    protected $table = 'detalle_devolucion';
    protected $fillable = [
        'cantidad',
        'devolucion_id',
        'producto_almacen_id',
    ];
    
    
}
