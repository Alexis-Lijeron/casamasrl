<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::create([
            'nombre' => 'Producto 1',
            'descripcion' => 'Descripción del producto 1',
            'stock_minimo' => 10,
            'precio_venta' => 100.00,
            'categoria_id' => 1,
            'marca_id' => 1,
        ]);
        
        Producto::create([
            'nombre' => 'Producto 2',
            'descripcion' => 'Descripción del producto 2',
            'stock_minimo' => 5,
            'precio_venta' => 50.00,
            'categoria_id' => 2,
            'marca_id' => 1,
        ]);
        
        Producto::create([
            'nombre' => 'Producto 3',
            'descripcion' => 'Descripción del producto 3',
            'stock_minimo' => 20,
            'precio_venta' => 200.00,
            'categoria_id' => 1,
            'marca_id' => 1,
        ]);
    }
}
