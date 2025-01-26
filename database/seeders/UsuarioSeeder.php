<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nombre' => 'Carlos',
            'apellido' => 'García',
            'email' => 'carlos@gmail.com',
            'password' => Hash::make('12345678'),
            'telefono' => '74566215',
            'rol_id' => 1
        ]);
        
        Usuario::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('12345678'),
            'telefono' => '77558866',
            'rol_id' => 2
        ]);
    }
}
