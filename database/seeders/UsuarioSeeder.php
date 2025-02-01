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
        $usuarios = [
            [
                'nombre' => 'Carlos',
                'apellido' => 'García',
                'email' => 'carlos@gmail.com',
                'password' => Hash::make('12345678'),
                'telefono' => '74566215'
            ],
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'email' => 'juan@gmail.com',
                'password' => Hash::make('12345678'),
                'telefono' => '77558866'
            ]
        ];

        foreach ($usuarios as $usuario) {
            Usuario::create($usuario);
        }
    }
}
