<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    
    protected $table = 'pagos';
    protected $fillable = [
        'monto',
        'fecha_pago',
        'venta_id',
        'metodo_pago_id',
        'estado',
        'descripcion'
    ];
    
    // Relación uno a muchos (inversa) con la tabla nota_ventas
    public function notaVenta()
    {
        return $this->belongsTo(NotaVenta::class, 'venta_id');
    }
    
    // Relación uno a muchos (inversa) con la tabla metodos_pagos
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }
}
