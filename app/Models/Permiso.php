<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;
    
    protected $table = 'permisos';
    protected $fillable = [
        'nombre',
        'descripcion'
    ];
    
    // Relación muchos a muchos con la tabla roles
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'roles_permisos', 'permiso_id', 'rol_id')->withTimestamps();
    }
}
