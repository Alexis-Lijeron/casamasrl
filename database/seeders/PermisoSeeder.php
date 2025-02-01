<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
       $permissions = [
            // Menú permissions
            ['nombre' => 'Ver menú usuarios', 'slug' => 'menu.usuarios'],
            ['nombre' => 'Ver menú roles y permisos', 'slug' => 'menu.roles-permisos'],
            ['nombre' => 'Ver menú clientes', 'slug' => 'menu.clientes'],
            ['nombre' => 'Ver menú productos', 'slug' => 'menu.productos'],
            ['nombre' => 'Ver menú proveedores', 'slug' => 'menu.proveedores'],
            ['nombre' => 'Ver menú compras', 'slug' => 'menu.compras'],
            ['nombre' => 'Ver menú ventas', 'slug' => 'menu.ventas'],
            ['nombre' => 'Ver menú pagos', 'slug' => 'menu.pagos'],
            ['nombre' => 'Ver menú inventario', 'slug' => 'menu.inventario'],
            ['nombre' => 'Ver menú reportes', 'slug' => 'menu.reportes'],

            // Users management
            ['nombre' => 'Crear usuarios', 'slug' => 'usuarios.crear'],
            ['nombre' => 'Editar usuarios', 'slug' => 'usuarios.editar'],
            ['nombre' => 'Eliminar usuarios', 'slug' => 'usuarios.eliminar'],
            ['nombre' => 'Ver lista de usuarios', 'slug' => 'usuarios.listar'],

            // Roles management
            ['nombre' => 'Crear roles', 'slug' => 'roles.crear'],
            ['nombre' => 'Editar roles', 'slug' => 'roles.editar'],
            ['nombre' => 'Eliminar roles', 'slug' => 'roles.eliminar'],
            ['nombre' => 'Ver lista de roles', 'slug' => 'roles.listar'],

            // Permissions management
            ['nombre' => 'Asignar permisos', 'slug' => 'permisos.asignar'],
            ['nombre' => 'Ver lista de permisos', 'slug' => 'permisos.listar'],

            // Clients management
            ['nombre' => 'Crear clientes', 'slug' => 'clientes.crear'],
            ['nombre' => 'Editar clientes', 'slug' => 'clientes.editar'],
            ['nombre' => 'Eliminar clientes', 'slug' => 'clientes.eliminar'],
            ['nombre' => 'Ver lista de clientes', 'slug' => 'clientes.listar'],

            // Products management
            ['nombre' => 'Crear productos', 'slug' => 'productos.crear'],
            ['nombre' => 'Editar productos', 'slug' => 'productos.editar'],
            ['nombre' => 'Eliminar productos', 'slug' => 'productos.eliminar'],
            ['nombre' => 'Ver lista de productos', 'slug' => 'productos.listar'],

            // Categories management
            ['nombre' => 'Crear categorías', 'slug' => 'categorias.crear'],
            ['nombre' => 'Editar categorías', 'slug' => 'categorias.editar'],
            ['nombre' => 'Eliminar categorías', 'slug' => 'categorias.eliminar'],
            ['nombre' => 'Ver lista de categorías', 'slug' => 'categorias.listar'],

            // Brands management
            ['nombre' => 'Crear marcas', 'slug' => 'marcas.crear'],
            ['nombre' => 'Editar marcas', 'slug' => 'marcas.editar'],
            ['nombre' => 'Eliminar marcas', 'slug' => 'marcas.eliminar'],
            ['nombre' => 'Ver lista de marcas', 'slug' => 'marcas.listar'],

            // Warehouses management
            ['nombre' => 'Crear almacenes', 'slug' => 'almacenes.crear'],
            ['nombre' => 'Editar almacenes', 'slug' => 'almacenes.editar'],
            ['nombre' => 'Eliminar almacenes', 'slug' => 'almacenes.eliminar'],
            ['nombre' => 'Ver lista de almacenes', 'slug' => 'almacenes.listar'],

            // Suppliers management
            ['nombre' => 'Crear proveedores', 'slug' => 'proveedores.crear'],
            ['nombre' => 'Editar proveedores', 'slug' => 'proveedores.editar'],
            ['nombre' => 'Eliminar proveedores', 'slug' => 'proveedores.eliminar'],
            ['nombre' => 'Ver lista de proveedores', 'slug' => 'proveedores.listar'],

            // Purchases management
            ['nombre' => 'Crear compras', 'slug' => 'compras.crear'],
            ['nombre' => 'Ver lista de compras', 'slug' => 'compras.listar'],

            // Promotions management
            ['nombre' => 'Crear promociones', 'slug' => 'promociones.crear'],
            ['nombre' => 'Editar promociones', 'slug' => 'promociones.editar'],
            ['nombre' => 'Eliminar promociones', 'slug' => 'promociones.eliminar'],
            ['nombre' => 'Ver lista de promociones', 'slug' => 'promociones.listar'],

            // Sales management
            ['nombre' => 'Crear ventas', 'slug' => 'ventas.crear'],
            ['nombre' => 'Ver lista de ventas', 'slug' => 'ventas.listar'],

            // Reports management
            ['nombre' => 'Consultar reportes', 'slug' => 'reportes.consultar'],
            ['nombre' => 'Generar PDF de reportes', 'slug' => 'reportes.generar-pdf'],
        ];

        foreach ($permissions as $permission) {
            Permiso::create([
                'nombre' => $permission['nombre'],
                'slug' => $permission['slug'],
                'descripcion' => $permission['descripcion'] ?? null
            ]);
        }
    }
}
