<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    
    protected $table = 'clientes';    
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'genero',
    ];
    
    // Relación uno a muchos con la tabla nota_ventas
    public function notaVentas()
    {
        return $this->hasMany(NotaVenta::class, 'cliente_id');
    }
    
}
