<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono'
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
    
    // Relación muchos a uno con la tabla rol
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'rol_usuario');
    }

    public function hasRole($role): bool
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    public function hasPermission($permission): bool
    {
        return $this->roles()->whereHas('permisos', function ($query) use ($permission) {
            $query->where('slug', $permission);
        })->exists();
    }
}
