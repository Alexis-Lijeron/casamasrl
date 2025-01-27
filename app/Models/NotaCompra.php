<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaCompra extends Model
{
    use HasFactory;

    protected $table = 'nota_compras';
    protected $fillable = [
        'monto_total',
        'fecha_compra',
        'estado',
        'proveedor_id',
        'usuario_id',
    ];

    // Relación uno a muchos (inversa) con la tabla proveedores
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    // Relación muchos a muchos con la tabla producto_almacen
    public function productosAlmacen()
    {
        return $this->belongsToMany(ProductoAlmacen::class, 'detalle_compras', 'compra_id', 'producto_almacen_id')
            ->withPivot('cantidad', 'precio_compra')
            ->withTimestamps();
    }

    // Relación uno a muchos (inversa) con la tabla usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

}
