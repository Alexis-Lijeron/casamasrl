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
            ],
            [
                'nombre' => 'Encargado',
                'slug' => 'rol.encargado',
                'description' => 'Rol con acceso amplio, excluyendo gestión de usuarios, roles y permisos'
            ],
            [
                'nombre' => 'Comprador',
                'slug' => 'rol.comprador',
                'description' => 'Rol enfocado en inventario, proveedores, productos y compras'
            ]
        ];

        foreach ($roles as $role) {
            Rol::create($role);
        }
    }
}
