<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_venta',
        'stock_minimo',
        'url_imagen',
        'categoria_id',
        'marca_id'
    ];

    // Relación muchos a muchos con la tabla almacenes
    public function almacenes()
    {
        return $this->belongsToMany(Almacen::class, 'producto_almacen', 'producto_id', 'almacen_id')
            ->withPivot('stock', 'fecha_vencimiento')
            ->withTimestamps();
    }

    // Relación uno a muchos (inversa) con la tabla categorias
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Relación uno a muchos (inversa) con la tabla marcas
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function promociones()
{
    return $this->belongsToMany(Promocion::class, 'producto_promocion')
                ->withPivot('precio_con_descuento')
                ->withTimestamps();
}

public function getPrecioActualAttribute()
{
    $promocionActiva = $this->promociones()
        ->where('fecha_inicio', '<=', now())
        ->where('fecha_fin', '>=', now())
        ->where('estado', 'activo')
        ->first();

    return $promocionActiva
        ? $promocionActiva->pivot->precio_con_descuento
        : $this->precio_venta;
}

}
