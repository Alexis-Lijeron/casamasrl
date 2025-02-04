<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nombre'   => 'Juan',
                'apellido' => 'Pérez',
                'email'    => 'juanperez@gmail.com',
                'telefono' => '712345678',
                'genero'   => 'Masculino',
            ],
            [
                'nombre'   => 'María',
                'apellido' => 'García',
                'email'    => 'mariagarcia@hotmail.com',
                'telefono' => '712345679',
                'genero'   => 'Femenino',
            ],
            [
                'nombre'   => 'Carlos',
                'apellido' => 'Rodríguez',
                'email'    => 'carlosrodriguez@gmail.com',
                'telefono' => '712345680',
                'genero'   => 'Masculino',
            ],
            [
                'nombre'   => 'Ana',
                'apellido' => 'López',
                'email'    => 'analopez@hotmail.com',
                'telefono' => '712345681',
                'genero'   => 'Femenino',
            ],
            [
                'nombre'   => 'Luis',
                'apellido' => 'Martínez',
                'email'    => 'luismartinez@gmail.com',
                'telefono' => '712345682',
                'genero'   => 'Masculino',
            ],
            [
                'nombre'   => 'Carmen',
                'apellido' => 'Sánchez',
                'email'    => 'carmensanchez@hotmail.com',
                'telefono' => '712345683',
                'genero'   => 'Femenino',
            ],
            [
                'nombre'   => 'José',
                'apellido' => 'Díaz',
                'email'    => 'josediaz@gmail.com',
                'telefono' => '712345684',
                'genero'   => 'Masculino',
            ],
            [
                'nombre'   => 'Laura',
                'apellido' => 'Ramírez',
                'email'    => 'lauraramirez@hotmail.com',
                'telefono' => '712345685',
                'genero'   => 'Femenino',
            ],
            [
                'nombre'   => 'Miguel',
                'apellido' => 'Gómez',
                'email'    => 'migulegomez@gmail.com',
                'telefono' => '712345686',
                'genero'   => 'Masculino',
            ],
            [
                'nombre'   => 'Isabel',
                'apellido' => 'Torres',
                'email'    => 'isabeltorres@hotmail.com',
                'telefono' => '712345687',
                'genero'   => 'Femenino',
            ],
            [
                'nombre'   => 'Pedro',
                'apellido' => 'Ruiz',
                'email'    => 'pedroruiz@gmail.com',
                'telefono' => '712345688',
                'genero'   => 'Masculino',
            ],
            [
                'nombre'   => 'Elena',
                'apellido' => 'Morales',
                'email'    => 'elenamorales@hotmail.com',
                'telefono' => '712345689',
                'genero'   => 'Femenino',
            ],
            [
                'nombre'   => 'Jorge',
                'apellido' => 'Fernández',
                'email'    => 'jorgefernandez@gmail.com',
                'telefono' => '712345690',
                'genero'   => 'Masculino',
            ],
            [
                'nombre'   => 'Rosa',
                'apellido' => 'González',
                'email'    => 'rosagonzalez@hotmail.com',
                'telefono' => '712345691',
                'genero'   => 'Femenino',
            ],
            [
                'nombre'   => 'Ricardo',
                'apellido' => 'Castro',
                'email'    => 'ricardocastro@gmail.com',
                'telefono' => '712345692',
                'genero'   => 'Masculino',
            ],
            [
                'nombre'   => 'Lucía',
                'apellido' => 'Mendoza',
                'email'    => 'luciamendoza@hotmail.com',
                'telefono' => '712345693',
                'genero'   => 'Femenino',
            ],
            [
                'nombre'   => 'Manuel',
                'apellido' => 'Ríos',
                'email'    => 'manuelrios@gmail.com',
                'telefono' => '712345694',
                'genero'   => 'Masculino',
            ],
            [
                'nombre'   => 'Sofía',
                'apellido' => 'Romero',
                'email'    => 'sofiaromero@hotmail.com',
                'telefono' => '712345695',
                'genero'   => 'Femenino',
            ],
            [
                'nombre'   => 'Andrés',
                'apellido' => 'Herrera',
                'email'    => 'andresherrera@gmail.com',
                'telefono' => '712345696',
                'genero'   => 'Masculino',
            ],
            [
                'nombre'   => 'Claudia',
                'apellido' => 'Vargas',
                'email'    => 'claudiavargas@hotmail.com',
                'telefono' => '712345697',
                'genero'   => 'Femenino',
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
