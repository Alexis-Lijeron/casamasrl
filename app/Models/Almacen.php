<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    
    protected $table = 'almacenes';
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    
    // Relación muchos a muchos con la tabla productos
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_almacen', 'almacen_id', 'producto_id')
            ->withPivot('stock', 'fecha_vencimiento')
            ->withTimestamps();
    }
}
