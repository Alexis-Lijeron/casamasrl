<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = [
        'nombre',
    ];


    // Relación muchos a muchos con la tabla permisos
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'roles_permisos', 'rol_id', 'permiso_id')
        ->withTimestamps();
    }
    
    // Relación uno a muchos con la tabla usuarios
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'rol_id');
    }
}
