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
        $admin = Rol::where('nombre', 'Administrador')->first();
        $permisos = Permiso::all();

        // Asignar todos los permisos al rol Administrador
        $admin->permisos()->sync($permisos->pluck('id')->toArray());
    }
}
