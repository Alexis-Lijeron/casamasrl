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
            'nombre_empresa' => 'Lácteos del Valle',
            'nombre_encargado' => 'Carlos Mendoza',
            'direccion' => 'Av. Central 123, Ciudad A',
            'telefono' => '5551234567',
            'email' => 'contacto@lacteosdelvalle.com',
        ]);

        Proveedor::create([
            'nombre_empresa' => 'Quesos La Finca',
            'nombre_encargado' => 'María López',
            'direccion' => 'Calle 45 #678, Ciudad B',
            'telefono' => '5559876543',
            'email' => 'ventas@quesoslafinca.com',
        ]);
    }
}
