<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = [
            [
                'nombre_empresa'   => 'Lácteos Pil Andina S.A.',
                'nombre_encargado' => 'Héctor Villanueva',
                'direccion'        => 'Av. 6 de Agosto 1234, La Paz, Bolivia',
                'telefono'         => '24441234',
                'email'            => 'contacto@pilandina.com',
            ],
            [
                'nombre_empresa'   => 'Delizia S.A.',
                'nombre_encargado' => 'María Sánchez',
                'direccion'        => 'Av. Circunvalación 4567, Santa Cruz, Bolivia',
                'telefono'         => '39991234',
                'email'            => 'info@delizia.com.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos Santa Clara S.R.L.',
                'nombre_encargado' => 'Roberto Gómez',
                'direccion'        => 'Calle Los Pinos 789, Cochabamba, Bolivia',
                'telefono'         => '47331234',
                'email'            => 'ventas@santaclara.com.bo',
            ],
            [
                'nombre_empresa'   => 'Quesos La Finca S.A.',
                'nombre_encargado' => 'Cecilia Rojas',
                'direccion'        => 'Calle Principal 234, Tarija, Bolivia',
                'telefono'         => '43341234',
                'email'            => 'contacto@quesoslafinca.com',
            ],
            [
                'nombre_empresa'   => 'Cooperativa Lechera Boliviana',
                'nombre_encargado' => 'Luis Mendoza',
                'direccion'        => 'Av. 16 de Julio 987, Sucre, Bolivia',
                'telefono'         => '42651234',
                'email'            => 'info@cooperativalectera.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos del Sur S.A.',
                'nombre_encargado' => 'Gloria Castro',
                'direccion'        => 'Av. 20 de Octubre 321, Santa Cruz, Bolivia',
                'telefono'         => '39981234',
                'email'            => 'ventas@lacteosdelsur.com.bo',
            ],
            [
                'nombre_empresa'   => 'Distribuidora Danone Bolivia S.A.',
                'nombre_encargado' => 'Andrés Paredes',
                'direccion'        => 'Calle Empresarial 456, La Paz, Bolivia',
                'telefono'         => '24451234',
                'email'            => 'contacto@danone.bo',
            ],
            [
                'nombre_empresa'   => 'Quesos Artesanales del Altiplano',
                'nombre_encargado' => 'Sofía Morales',
                'direccion'        => 'Calle Artesanal 112, El Alto, Bolivia',
                'telefono'         => '24461234',
                'email'            => 'info@quesosartesanales.com.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos y Derivados de Cochabamba',
                'nombre_encargado' => 'Jorge Ramírez',
                'direccion'        => 'Av. Blanco Galindo 678, Cochabamba, Bolivia',
                'telefono'         => '47351234',
                'email'            => 'ventas@lacteoscochabamba.com.bo',
            ],
            [
                'nombre_empresa'   => 'Proveedor Alpina Bolivia',
                'nombre_encargado' => 'Elena Vargas',
                'direccion'        => 'Calle Alpina 890, La Paz, Bolivia',
                'telefono'         => '24471234',
                'email'            => 'contacto@alpina.bo',
            ],
            [
                'nombre_empresa'   => 'Sancor Bolivia Distribuciones',
                'nombre_encargado' => 'Ricardo Suárez',
                'direccion'        => 'Av. 6 de Agosto 567, La Paz, Bolivia',
                'telefono'         => '24481234',
                'email'            => 'ventas@sancor.bo',
            ],
            [
                'nombre_empresa'   => 'Gloria Lácteos Bolivia',
                'nombre_encargado' => 'Patricia Fernández',
                'direccion'        => 'Calle Gloria 345, Cochabamba, Bolivia',
                'telefono'         => '47361234',
                'email'            => 'info@gloria.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos del Valle',
                'nombre_encargado' => 'Marco Díaz',
                'direccion'        => 'Av. del Valle 234, La Paz, Bolivia',
                'telefono'         => '24491234',
                'email'            => 'contacto@lacteosdelvalle.com',
            ],
            [
                'nombre_empresa'   => 'Lácteos Andinos S.A.',
                'nombre_encargado' => 'Verónica Quispe',
                'direccion'        => 'Calle de los Andes 101, El Alto, Bolivia',
                'telefono'         => '24401234',
                'email'            => 'ventas@lacteosandinos.com.bo',
            ],
            [
                'nombre_empresa'   => 'Quesos del Oriente',
                'nombre_encargado' => 'Julio Pérez',
                'direccion'        => 'Av. Oriente 567, Santa Cruz, Bolivia',
                'telefono'         => '39991235',
                'email'            => 'info@quesosdeloriente.com.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos del Norte S.R.L.',
                'nombre_encargado' => 'Fernando Salazar',
                'direccion'        => 'Calle Norte 789, La Paz, Bolivia',
                'telefono'         => '24411234',
                'email'            => 'contacto@lacteosdelnorte.com.bo',
            ],
            [
                'nombre_empresa'   => 'Cooperativa de Lácteos de Tarija',
                'nombre_encargado' => 'Marta Rincón',
                'direccion'        => 'Av. Independencia 234, Tarija, Bolivia',
                'telefono'         => '43351234',
                'email'            => 'info@cooperativatarija.bo',
            ],
            [
                'nombre_empresa'   => 'Quesos y Derivados La Andina',
                'nombre_encargado' => 'Oscar Mendoza',
                'direccion'        => 'Calle Andina 345, Cochabamba, Bolivia',
                'telefono'         => '47371234',
                'email'            => 'ventas@quesoslaandina.com.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos Modernos S.A.',
                'nombre_encargado' => 'Claudia Herrera',
                'direccion'        => 'Av. Modernos 678, Santa Cruz, Bolivia',
                'telefono'         => '39981235',
                'email'            => 'contacto@lacteosmodernos.com.bo',
            ],
            [
                'nombre_empresa'   => 'Distribuidora de Lácteos La Estrella',
                'nombre_encargado' => 'Diego Romero',
                'direccion'        => 'Calle La Estrella 890, La Paz, Bolivia',
                'telefono'         => '24421234',
                'email'            => 'ventas@laestrella.com.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos y Cremas del Valle',
                'nombre_encargado' => 'Rosa Morales',
                'direccion'        => 'Av. Vallecito 123, Cochabamba, Bolivia',
                'telefono'         => '47381234',
                'email'            => 'info@lacteosycremasdelvalle.com.bo',
            ],
            [
                'nombre_empresa'   => 'Quesos Tradicionales del Altiplano',
                'nombre_encargado' => 'Juan Castillo',
                'direccion'        => 'Calle Altiplano 456, El Alto, Bolivia',
                'telefono'         => '24431234',
                'email'            => 'contacto@quesostradicionales.com.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos del Cochabamba',
                'nombre_encargado' => 'Andrea Pacheco',
                'direccion'        => 'Av. Blanco Galindo 567, Cochabamba, Bolivia',
                'telefono'         => '47391234',
                'email'            => 'contacto@lacteoscochabamba.com.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos y Quesos del Sur',
                'nombre_encargado' => 'Esteban Lara',
                'direccion'        => 'Calle Sur 678, Santa Cruz, Bolivia',
                'telefono'         => '39971234',
                'email'            => 'info@lacteosyquesosdelsur.com.bo',
            ],
            [
                'nombre_empresa'   => 'Distribuidora Integral de Lácteos',
                'nombre_encargado' => 'Marina Robles',
                'direccion'        => 'Av. Central 789, La Paz, Bolivia',
                'telefono'         => '24441235',
                'email'            => 'ventas@distribuidoraintegral.com.bo',
            ],
            [
                'nombre_empresa'   => 'Cooperativa Lechera del Oriente',
                'nombre_encargado' => 'Gabriel Flores',
                'direccion'        => 'Calle Oriente 890, Santa Cruz, Bolivia',
                'telefono'         => '39961234',
                'email'            => 'contacto@cooperativalecheraoriente.com.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos del Potosí S.R.L.',
                'nombre_encargado' => 'Julieta Rojas',
                'direccion'        => 'Av. 16 de Julio 901, Potosí, Bolivia',
                'telefono'         => '59121234',
                'email'            => 'info@lacteospotosi.com.bo',
            ],
            [
                'nombre_empresa'   => 'Quesos y Derivados Santa Cruz',
                'nombre_encargado' => 'Martin Guzmán',
                'direccion'        => 'Calle Santa Cruz 234, Santa Cruz, Bolivia',
                'telefono'         => '39951234',
                'email'            => 'ventas@quesossantacruz.com.bo',
            ],
            [
                'nombre_empresa'   => 'Lácteos Premium Bolivia',
                'nombre_encargado' => 'Silvana Ortega',
                'direccion'        => 'Av. Premium 345, La Paz, Bolivia',
                'telefono'         => '24451235',
                'email'            => 'contacto@lacteospremium.com.bo',
            ],
            [
                'nombre_empresa'   => 'Distribuidora Agroindustrial de Lácteos',
                'nombre_encargado' => 'Fabián Delgado',
                'direccion'        => 'Calle Agroindustrial 456, Cochabamba, Bolivia',
                'telefono'         => '47351235',
                'email'            => 'info@distribuidoraagroindustrial.com.bo',
            ],
        ];

        foreach ($proveedores as $proveedor) {
            Proveedor::create($proveedor);
        }
    }
}
