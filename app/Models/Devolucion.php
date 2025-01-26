<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;
    
    protected $table = 'devoluciones';
    protected $fillable = [
        'compra_id',
        'usuario_id',
        'fecha_devolucion',
        'monto_total',
        'motivo',
    ];
    
    // Relación uno a muchos (inversa) con la tabla nota_compras
    public function notaCompra()
    {
        return $this->belongsTo(NotaCompra::class, 'compra_id');
    }
    
    // Relación muchos a muchos con la tabla producto_almacen
    public function productosAlmacen()
    {
        return $this->belongsToMany(ProductoAlmacen::class, 'detalle_devolucion', 'devolucion_id', 'producto_almacen_id')
            ->withPivot('cantidad')
            ->withTimestamps();
    }
    
    // Relación uno a muchos (inversa) con la tabla usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
    
}
