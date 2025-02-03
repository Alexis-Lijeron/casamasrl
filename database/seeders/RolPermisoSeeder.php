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
        $encargado = Rol::where('slug', 'rol.encargado')->firstOrFail();
        $comprador = Rol::where('slug', 'rol.comprador')->firstOrFail();

        // Asignar todos los permisos al administrador (remains the same)
        $admin->permisos()->sync(Permiso::all());

        // Asignar permisos específicos al vendedor
        $vendedor->permisos()->sync(
            Permiso::whereIn('slug', [
                // Productos (solo ver listas)
                'menu.productos',
                'submenu.productos.ver',
                'productos.listar',
                'submenu.categorias.ver',
                'submenu.marcas.ver',

                // Promociones (todo)
                'menu.productos',
                'submenu.promociones.ver',
                'promociones.crear',
                'promociones.editar',
                'promociones.eliminar',
                'promociones.listar',

                // Ajustes de inventario
                'menu.inventario',
                'submenu.ajustes.ver',

                // Ventas y pagos
                'menu.ventas',
                'menu.pagos',
                'ventas.crear',
                'ventas.listar',
                'submenu.pagos.ver',

                // Clientes (gestión completa)
                'menu.clientes',
                'clientes.crear',
                'clientes.editar',
                'clientes.eliminar',
                'clientes.listar'
            ])->pluck('id')
        );

        // Permisos para Encargado (todos los permisos menos gestión de usuarios, roles y permisos)
        $encargadoPermisos = Permiso::whereNotIn('slug', [
            // Exclusiones de gestión de usuarios, roles y permisos
            'menu.usuarios',
            'menu.roles-permisos',
            'submenu.roles.ver',
            'submenu.permisos.ver',
            'submenu.permisos.asignar',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',
            'usuarios.listar',
            'roles.crear',
            'roles.editar',
            'roles.eliminar',
            'roles.listar',
            'permisos.asignar',
            'permisos.listar'
        ])->pluck('id');
        $encargado->permisos()->sync($encargadoPermisos);

        // Permisos para Comprador
        $compradorPermisos = Permiso::whereIn('slug', [
            // Ajustes de inventario
            'menu.inventario',
            'submenu.ajustes.ver',

            // Proveedores
            'menu.proveedores',
            'proveedores.listar',

            // Promociones
            'menu.productos',
            'submenu.promociones.ver',
            'promociones.listar',

            // Gestión de productos, almacenes, marcas
            'menu.productos',
            'submenu.productos.ver',
            'submenu.categorias.ver',
            'submenu.marcas.ver',
            'submenu.almacenes.ver',
            'productos.listar',
            'categorias.listar',
            'marcas.listar',
            'almacenes.listar',

            // Compras
            'menu.compras',
            'submenu.compras.ver',
            'compras.crear',
            'compras.listar'
        ])->pluck('id');
        $comprador->permisos()->sync($compradorPermisos);
    }
}
