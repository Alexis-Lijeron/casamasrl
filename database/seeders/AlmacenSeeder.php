<?php

namespace Database\Seeders;

use App\Models\Almacen;
use Illuminate\Database\Seeder;

class AlmacenSeeder extends Seeder
{
    public function run(): void
    {
        $almacenes = [
            [
                'nombre' => 'Almacén Central',
                'descripcion' => 'Ubicado en el centro de la ciudad, gestionando el inventario principal.',
            ],
            [
                'nombre' => 'Almacén Norte',
                'descripcion' => 'Focalizado en la distribución a la zona norte de la ciudad.',
            ],
            [
                'nombre' => 'Almacén Sur',
                'descripcion' => 'Encargado de la logística y distribución en la zona sur.',
            ],
            [
                'nombre' => 'Almacén Este',
                'descripcion' => 'Suministra productos a la zona este y áreas aledañas.',
            ],
            [
                'nombre' => 'Almacén Oeste',
                'descripcion' => 'Se encarga de la distribución en la zona oeste.',
            ],
            [
                'nombre' => 'Almacén Industrial',
                'descripcion' => 'Diseñado para grandes volúmenes y almacenamiento industrial.',
            ],
            [
                'nombre' => 'Almacén Refrigerado',
                'descripcion' => 'Especializado en productos que requieren condiciones de refrigeración.',
            ],
            [
                'nombre' => 'Almacén de Distribución',
                'descripcion' => 'Optimizado para la logística y distribución de productos lácteos.',
            ],
            [
                'nombre' => 'Almacén Regional',
                'descripcion' => 'Atiende necesidades de inventario a nivel regional.',
            ],
            [
                'nombre' => 'Almacén Logístico',
                'descripcion' => 'Centraliza el control de stock y la logística de la empresa.',
            ],
        ];

        foreach ($almacenes as $almacen) {
            Almacen::create($almacen);
        }
    }
}
