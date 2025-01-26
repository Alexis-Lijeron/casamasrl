<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        // Marcas de productos farmacéuticos
        Marca::create(['nombre' => 'Bayer']);
        Marca::create(['nombre' => 'Pfizer']);
        Marca::create(['nombre' => 'Roche']);
        Marca::create(['nombre' => 'Novartis']);
        Marca::create(['nombre' => 'Merck']);
        Marca::create(['nombre' => 'Sanofi']);
        Marca::create(['nombre' => 'GlaxoSmithKline']);
        Marca::create(['nombre' => 'Johnson & Johnson']);
        Marca::create(['nombre' => 'AbbVie']);
        Marca::create(['nombre' => 'AstraZeneca']);
        
    }
}
