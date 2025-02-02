<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nombre' => 'Administrador',
                'slug' => 'rol.admin',
                'description' => 'Rol con acceso total al sistema'
            ],
            [
                'nombre' => 'Vendedor',
                'slug' => 'rol.vendedor',
                'description' => 'Rol con acceso a funciones de ventas'
            ]
        ];

        foreach ($roles as $role) {
            Rol::create($role);
        }
    }
}
