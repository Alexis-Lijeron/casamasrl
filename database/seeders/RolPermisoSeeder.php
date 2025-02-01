<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolPermisoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Rol::where('slug', 'rol.admin')->firstOrFail();
        $vendedor = Rol::where('slug', 'rol.vendedor')->firstOrFail();

        // Asignar todos los permisos al administrador
        $admin->permisos()->sync(Permiso::all());

        // Asignar permisos específicos al vendedor
        $vendedor->permisos()->sync(
            Permiso::whereIn('slug', [
                'menu.ventas',
                'menu.clientes',
                'menu.productos',
                'ventas.crear',
                'ventas.listar',
                'clientes.listar',
                'productos.listar'
            ])->pluck('id')
        );
    }
}
