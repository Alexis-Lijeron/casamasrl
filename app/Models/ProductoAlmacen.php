<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoAlmacen extends Model
{
    use HasFactory;

    protected $table = 'producto_almacen';
    protected $fillable = [
        'producto_id',
        'almacen_id',
        'stock',
        'fecha_vencimiento'
    ];

    // Relación uno a muchos con la tabla ajuste_inventarios
    public function ajustesInventario()
    {
        return $this->belongsToMany(AjusteInventario::class, 'detalle_ajustes', 'producto_almacen_id', 'ajuste_inventario_id')
            ->withPivot('cantidad');
    }

    // Relación uno a muchos con la tabla nota_compras
    public function notaCompras()
    {
        return $this->belongsToMany(NotaCompra::class, 'detalle_compras', 'producto_almacen_id', 'compra_id')
            ->withPivot('cantidad', 'precio_compra');
    }

    // Relación uno a muchos con la tabla nota_ventas
    public function notaVentas()
    {
        return $this->belongsToMany(NotaVenta::class, 'detalle_ventas', 'producto_almacen_id', 'venta_id')
            ->withPivot('cantidad', 'precio_venta');
    }


    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}
