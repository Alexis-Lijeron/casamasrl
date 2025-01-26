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
            'nombre' => 'Medicamentos',
            'descripcion' => 'Productos farmacéuticos'
        ]);        
        
        Categoria::create([
            'nombre' => 'Inyectables',
            'descripcion' => 'Productos inyectables'
        ]);
        
        Categoria::create([
            'nombre' => 'Vacunas',
            'descripcion' => 'Vacunas para enfermedades'
        ]);
        
        Categoria::create([
            'nombre' => 'Jarabes',
            'descripcion' => 'Jarabes para enfermedades'
        ]);
        
        Categoria::create([
            'nombre' => 'Pastillas',
            'descripcion' => 'Pastillas para enfermedades'
        ]);
    }
}
