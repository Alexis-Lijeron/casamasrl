<?php
namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Database\Seeder;

class UsuarioRolSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Rol::where('slug', 'rol.admin')->firstOrFail();
        $vendedor = Rol::where('slug', 'rol.vendedor')->firstOrFail();

        // Asignar rol de administrador a Carlos
        $carlos = Usuario::where('email', 'carlos@gmail.com')->firstOrFail();
        $carlos->roles()->sync([$admin->id]);

        // Asignar rol de vendedor a Juan
        $juan = Usuario::where('email', 'juan@gmail.com')->firstOrFail();
        $juan->roles()->sync([$vendedor->id]);
    }
}
