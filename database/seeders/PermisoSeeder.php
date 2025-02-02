<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
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
            ['nombre' => 'Ver menú de roles', 'slug' => 'submenu.roles.ver'],
            ['nombre' => 'Ver menú de permisos', 'slug' => 'submenu.permisos.ver'],
            ['nombre' => 'Ver menú asignación de permisos', 'slug' => 'submenu.permisos.asignar'],
            ['nombre' => 'Ver menú de productos', 'slug' => 'submenu.productos.ver'],
            ['nombre' => 'Ver menú categorías', 'slug' => 'submenu.categorias.ver'],
            ['nombre' => 'Ver menú promociones', 'slug' => 'submenu.promociones.ver'],
            ['nombre' => 'Ver menú marcas', 'slug' => 'submenu.marcas.ver'],
            ['nombre' => 'Ver menú almacenes', 'slug' => 'submenu.almacenes.ver'],
            ['nombre' => 'Ver menú ajustes de inventario', 'slug' => 'submenu.ajustes.ver'],
            ['nombre' => 'Ver menú lista de compras', 'slug' => 'submenu.compras.ver'],
            ['nombre' => 'Ver menú lista de pagos', 'slug' => 'submenu.pagos.ver'],
            ['nombre' => 'Ver menú métodos de pago', 'slug' => 'submenu.metodos-pago.ver'],
            ['nombre' => 'Ver menú reportes de ventas', 'slug' => 'submenu.reportes.ventas'],
            ['nombre' => 'Ver menú reportes de compras', 'slug' => 'submenu.reportes.compras'],
            ['nombre' => 'Ver menú reportes de pagos', 'slug' => 'submenu.reportes.pagos'],
            ['nombre' => 'Crear usuarios', 'slug' => 'usuarios.crear'],
            ['nombre' => 'Editar usuarios', 'slug' => 'usuarios.editar'],
            ['nombre' => 'Eliminar usuarios', 'slug' => 'usuarios.eliminar'],
            ['nombre' => 'Ver lista de usuarios', 'slug' => 'usuarios.listar'],
            ['nombre' => 'Crear roles', 'slug' => 'roles.crear'],
            ['nombre' => 'Editar roles', 'slug' => 'roles.editar'],
            ['nombre' => 'Eliminar roles', 'slug' => 'roles.eliminar'],
            ['nombre' => 'Ver lista de roles', 'slug' => 'roles.listar'],
            ['nombre' => 'Asignar permisos', 'slug' => 'permisos.asignar'],
            ['nombre' => 'Ver lista de permisos', 'slug' => 'permisos.listar'],
            ['nombre' => 'Crear clientes', 'slug' => 'clientes.crear'],
            ['nombre' => 'Editar clientes', 'slug' => 'clientes.editar'],
            ['nombre' => 'Eliminar clientes', 'slug' => 'clientes.eliminar'],
            ['nombre' => 'Ver lista de clientes', 'slug' => 'clientes.listar'],
            ['nombre' => 'Crear productos', 'slug' => 'productos.crear'],
            ['nombre' => 'Editar productos', 'slug' => 'productos.editar'],
            ['nombre' => 'Eliminar productos', 'slug' => 'productos.eliminar'],
            ['nombre' => 'Ver lista de productos', 'slug' => 'productos.listar'],
            ['nombre' => 'Crear categorías', 'slug' => 'categorias.crear'],
            ['nombre' => 'Editar categorías', 'slug' => 'categorias.editar'],
            ['nombre' => 'Eliminar categorías', 'slug' => 'categorias.eliminar'],
            ['nombre' => 'Ver lista de categorías', 'slug' => 'categorias.listar'],
            ['nombre' => 'Crear marcas', 'slug' => 'marcas.crear'],
            ['nombre' => 'Editar marcas', 'slug' => 'marcas.editar'],
            ['nombre' => 'Eliminar marcas', 'slug' => 'marcas.eliminar'],
            ['nombre' => 'Ver lista de marcas', 'slug' => 'marcas.listar'],
            ['nombre' => 'Crear almacenes', 'slug' => 'almacenes.crear'],
            ['nombre' => 'Editar almacenes', 'slug' => 'almacenes.editar'],
            ['nombre' => 'Eliminar almacenes', 'slug' => 'almacenes.eliminar'],
            ['nombre' => 'Ver lista de almacenes', 'slug' => 'almacenes.listar'],
            ['nombre' => 'Crear proveedores', 'slug' => 'proveedores.crear'],
            ['nombre' => 'Editar proveedores', 'slug' => 'proveedores.editar'],
            ['nombre' => 'Eliminar proveedores', 'slug' => 'proveedores.eliminar'],
            ['nombre' => 'Ver lista de proveedores', 'slug' => 'proveedores.listar'],
            ['nombre' => 'Crear compras', 'slug' => 'compras.crear'],
            ['nombre' => 'Ver lista de compras', 'slug' => 'compras.listar'],
            ['nombre' => 'Crear promociones', 'slug' => 'promociones.crear'],
            ['nombre' => 'Editar promociones', 'slug' => 'promociones.editar'],
            ['nombre' => 'Eliminar promociones', 'slug' => 'promociones.eliminar'],
            ['nombre' => 'Ver lista de promociones', 'slug' => 'promociones.listar'],
            ['nombre' => 'Crear ventas', 'slug' => 'ventas.crear'],
            ['nombre' => 'Ver lista de ventas', 'slug' => 'ventas.listar'],
            ['nombre' => 'Consultar reportes', 'slug' => 'reportes.consultar'],
            ['nombre' => 'Generar PDF de reportes', 'slug' => 'reportes.generar-pdf'],
        ];

        foreach ($permissions as $permission) {
            Permiso::firstOrCreate(
                ['nombre' => $permission['nombre']],
                ['slug' => $permission['slug'], 'descripcion' => $permission['descripcion'] ?? null]
            );
        }
    }
}
