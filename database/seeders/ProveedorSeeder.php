<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        Proveedor::create([
            'nombre_empresa' => 'ABC',
            'nombre_encargado' => 'Proveedor 1',
            'direccion' => 'Dirección 1',
            'telefono' => '12345678',
            'email' => 'proveedor1@gmail.com',
        ]);
        
        Proveedor::create([
            'nombre_empresa' => 'XYZ',
            'nombre_encargado' => 'Proveedor 2',
            'direccion' => 'Dirección 2',
            'telefono' => '87654321',
            'email' => 'proveedor2@gmail.com',
        ]);
    }
}
