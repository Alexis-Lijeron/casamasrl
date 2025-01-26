<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjusteInventario extends Model
{
    use HasFactory;
    
    protected $table = 'ajuste_inventarios';
    protected $fillable = [
        'tipo',
        'descripcion',
        'fecha',
        'usuario_id',
    ];
    
    // Relación muchos a muchos con la tabla producto_almacen
    public function productosAlmacen()
    {
        return $this->belongsToMany(ProductoAlmacen::class, 'detalle_ajustes', 'ajuste_inventario_id', 'producto_almacen_id')
            ->withPivot('cantidad')
            ->withTimestamps();
    }
    
    // Relación uno a muchos (inversa) con la tabla usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
