<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $table = 'promociones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'descuento',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_promocion')
                    ->withPivot('precio_con_descuento')
                    ->withTimestamps();
    }
    protected static function boot()
{
    parent::boot();

    static::saving(function ($promocion) {
        if ($promocion->fecha_inicio <= now() && $promocion->fecha_fin >= now()) {
            $promocion->estado = 'activo';
        } else {
            $promocion->estado = 'inactivo';
        }
    });
}
}
