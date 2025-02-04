<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    
    protected $table = 'categorias';
    protected $fillable = ['nombre', 'descripcion'];
    
    // Relación uno a muchos con la tabla productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}
