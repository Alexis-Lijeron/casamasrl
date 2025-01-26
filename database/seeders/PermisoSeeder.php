<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
        Permiso::create([
            'nombre' => 'Crear_Usuarios',
            'descripcion' => 'Crear usuarios',
        ]);
        
        Permiso::create([
            'nombre' => 'Editar_Usuarios',
            'descripcion' => 'Editar usuarios',
        ]);
        
        Permiso::create([
            'nombre' => 'Eliminar_Usuarios',
            'descripcion' => 'Eliminar usuarios',
        ]);
        
        Permiso::create([
            'nombre' => 'Ver_Usuarios',
            'descripcion' => 'Ver usuarios',
        ]);
        
        Permiso::create([
            'nombre' => 'Crear_Roles',
            'descripcion' => 'Crear roles',
        ]);
        
        Permiso::create([
            'nombre' => 'Editar_Roles',
            'descripcion' => 'Editar roles',
        ]);
        
        Permiso::create([
            'nombre' => 'Eliminar_Roles',
            'descripcion' => 'Eliminar roles',
        ]);
        
        Permiso::create([
            'nombre' => 'Ver_Roles',
            'descripcion' => 'Ver roles',
        ]);
        
        Permiso::create([
            'nombre' => 'Crear_Permisos',
            'descripcion' => 'Crear permisos',
        ]);
        
        Permiso::create([
            'nombre' => 'Editar_Permisos',
            'descripcion' => 'Editar permisos',
        ]);
        
        Permiso::create([
            'nombre' => 'Eliminar_Permisos',
            'descripcion' => 'Eliminar permisos',
        ]);
        
        Permiso::create([
            'nombre' => 'Ver_Permisos',
            'descripcion' => 'Ver permisos',
        ]);
    }
}
