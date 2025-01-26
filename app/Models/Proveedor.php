<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    
    protected $table = 'proveedores';
    protected $fillable = [
        'nombre_empresa',
        'nombre_encargado',
        'direccion',
        'telefono',
        'email'
    ];
    
    // Relación uno a muchos con la tabla nota_compras
    public function notaCompras()
    {
        return $this->hasMany(NotaCompra::class, 'proveedor_id');
    }
    
}
