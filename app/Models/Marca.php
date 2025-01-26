<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marcas';
    protected $fillable = [
        'nombre',
    ];
    
    // Relación uno a muchos con la tabla productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'marca_id');
    }
}
