<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion'
    ];

    // Relación muchos a muchos con la tabla roles
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'roles_permisos');
    }
}
