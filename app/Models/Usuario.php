<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'rol_id'
    ];
    
    protected $hidden = [
        'password',
    ];

    // Relación uno a muchos con la tabla nota_ventas
    public function notaVentas()
    {
        return $this->hasMany(NotaVenta::class, 'usuario_id');
    }
    
    // Relación uno a muchos con la tabla nota_compras
    public function notaCompras()
    {
        return $this->hasMany(NotaCompra::class, 'usuario_id');
    }
    
    // Relación uno a muchos con la tabla ajuste_inventarios
    public function ajusteInventarios()
    {
        return $this->hasMany(AjusteInventario::class, 'usuario_id');
    }

    // Relación uno a muchos con la tabla devoluciones
    public function devoluciones()
    {
        return $this->hasMany(Devolucion::class, 'usuario_id');
    }

    // Relación muchos a uno con la tabla rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
}
