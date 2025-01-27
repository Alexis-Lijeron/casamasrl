<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Categoria::create([
            'nombre' => 'Leches',
            'descripcion' => 'Variedades de leche líquida y en polvo'
        ]);

        Categoria::create([
            'nombre' => 'Quesos',
            'descripcion' => 'Diferentes tipos de quesos frescos y maduros'
        ]);

        Categoria::create([
            'nombre' => 'Yogures',
            'descripcion' => 'Yogures naturales y con sabores'
        ]);

        Categoria::create([
            'nombre' => 'Mantequillas',
            'descripcion' => 'Mantequillas y margarinas'
        ]);

        Categoria::create([
            'nombre' => 'Postres Lácteos',
            'descripcion' => 'Flanes, natillas y otros postres lácteos'
        ]);
    }
}
