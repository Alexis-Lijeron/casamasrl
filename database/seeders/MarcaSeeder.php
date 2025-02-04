<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        Marca::create(['nombre' => 'Nestlé']);
        Marca::create(['nombre' => 'Danone']);
        Marca::create(['nombre' => 'La Serenísima']);
        Marca::create(['nombre' => 'Alpura']);
        Marca::create(['nombre' => 'Lala']);
        Marca::create(['nombre' => 'Parmalat']);
        Marca::create(['nombre' => 'Sancor']);
        Marca::create(['nombre' => 'Gloria']);
        Marca::create(['nombre' => 'Yoplait']);
        Marca::create(['nombre' => 'Santa Clara']);
        Marca::create(['nombre' => 'PIL Andina']);
        Marca::create(['nombre' => 'Delizia']);
        Marca::create(['nombre' => 'Lacteos Bolivia']);
        Marca::create(['nombre' => 'Artesanal']);
    }
}
