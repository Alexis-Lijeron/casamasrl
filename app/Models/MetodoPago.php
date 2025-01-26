<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;
    
    protected $table = 'metodo_pagos';
    protected $fillable = ['nombre'];
    
    
    // Relación uno a muchos con la tabla pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'metodo_pago_id');
    }
}
