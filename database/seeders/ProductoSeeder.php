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
            'nombre' => 'Leche Entera',
            'descripcion' => 'Leche entera pasteurizada',
            'stock_minimo' => 10,
            'precio_venta' => 25.00,
            'categoria_id' => 1,
            'marca_id' => 1,
        ]);

        Producto::create([
            'nombre' => 'Queso Gouda',
            'descripcion' => 'Queso gouda madurado',
            'stock_minimo' => 5,
            'precio_venta' => 80.00,
            'categoria_id' => 2,
            'marca_id' => 2,
        ]);

        Producto::create([
            'nombre' => 'Yogur Natural',
            'descripcion' => 'Yogur natural sin azúcar',
            'stock_minimo' => 20,
            'precio_venta' => 30.00,
            'categoria_id' => 3,
            'marca_id' => 3,
        ]);
    }
}
