<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAjuste extends Model
{
    use HasFactory;
    
    protected $table = 'detalle_ajustes';
    protected $fillable = [
        'ajuste_inventario_id',
        'producto_almacen_id',
        'cantidad',
    ];
}
