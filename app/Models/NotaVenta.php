<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaVenta extends Model
{
    use HasFactory;

    protected $table = 'nota_ventas';
    protected $fillable = [
        'monto_total',
        'fecha_venta',
        'descuento',
        'cliente_id',
        'usuario_id',
    ];


    // Relación uno a muchos (inversa) con la tabla clientes
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación uno a muchos (inversa) con la tabla usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación uno a muchos con la tabla pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'venta_id');
    }

    // Relación muchos a muchos con la tabla producto_almacen
    public function productosAlmacen()
    {
        return $this->belongsToMany(ProductoAlmacen::class, 'detalle_ventas', 'venta_id', 'producto_almacen_id')
            ->withPivot('cantidad', 'precio_venta')
            ->withTimestamps();
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    // Metodo para obtener el estado de pago de la venta
    public function estadoPago()
    {
        $totalPagos = $this->pagos()->count();
        $pagosCompletados = $this->pagos()->where('estado', true)->count();

        if ($pagosCompletados === 0) {
            return 'Pendiente';
        } elseif ($pagosCompletados < $totalPagos) {
            return 'Parcialmente Pagado';
        } else {
            return 'Pagado';
        }
    }
}
