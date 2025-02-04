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
                'nombre_empresa'   => 'Lácteos del Valle',
                'nombre_encargado' => 'Carlos Mendoza',
                'direccion'        => 'Av. Central 123, Ciudad A',
                'telefono'         => '5551234567',
                'email'            => 'contacto@lacteosdelvalle.com',
            ],
            [
                'nombre_empresa'   => 'Quesos La Finca',
                'nombre_encargado' => 'María López',
                'direccion'        => 'Calle 45 #678, Ciudad B',
                'telefono'         => '5559876543',
                'email'            => 'ventas@quesoslafinca.com',
            ],
            [
                'nombre_empresa'   => 'Yogures del Norte',
                'nombre_encargado' => 'Pedro Rojas',
                'direccion'        => 'Av. del Sol 456, Ciudad C',
                'telefono'         => '5551122334',
                'email'            => 'info@yoguresdelnorte.com',
            ],
            [
                'nombre_empresa'   => 'Cremería Santa Marta',
                'nombre_encargado' => 'Ana Castillo',
                'direccion'        => 'Calle 12 #34, Ciudad D',
                'telefono'         => '5552233445',
                'email'            => 'contacto@cremeriasantamarta.com',
            ],
            [
                'nombre_empresa'   => 'Lácteos Andinos',
                'nombre_encargado' => 'Jorge Huanca',
                'direccion'        => 'Av. Andina 789, Ciudad E',
                'telefono'         => '5553344556',
                'email'            => 'ventas@lacteosandinos.com',
            ],
            [
                'nombre_empresa'   => 'Proveedor Alpina',
                'nombre_encargado' => 'Luisa Fernández',
                'direccion'        => 'Calle Alpina 101, Ciudad F',
                'telefono'         => '5554455667',
                'email'            => 'contacto@proveedoralpina.com',
            ],
            [
                'nombre_empresa'   => 'Quesos del Campo',
                'nombre_encargado' => 'Ricardo Soto',
                'direccion'        => 'Av. Rural 234, Ciudad G',
                'telefono'         => '5555566778',
                'email'            => 'info@quesosdelcampo.com',
            ],
            [
                'nombre_empresa'   => 'Lácteos La Serena',
                'nombre_encargado' => 'Mónica Silva',
                'direccion'        => 'Calle La Serena 567, Ciudad H',
                'telefono'         => '5556677889',
                'email'            => 'contacto@lacteoslaserena.com',
            ],
            [
                'nombre_empresa'   => 'Delicias Lácteas',
                'nombre_encargado' => 'Esteban Ruiz',
                'direccion'        => 'Av. Gourmet 890, Ciudad I',
                'telefono'         => '5557788990',
                'email'            => 'ventas@deliciaslacteas.com',
            ],
            [
                'nombre_empresa'   => 'Quesos Artesanales',
                'nombre_encargado' => 'Sofía Méndez',
                'direccion'        => 'Calle Artesanal 321, Ciudad J',
                'telefono'         => '5558899001',
                'email'            => 'info@quesosartesanales.com',
            ],
            [
                'nombre_empresa'   => 'Lácteos del Sur',
                'nombre_encargado' => 'Andrés Paredes',
                'direccion'        => 'Av. Sur 456, Ciudad K',
                'telefono'         => '5559900112',
                'email'            => 'contacto@lacteosdelsur.com',
            ],
            [
                'nombre_empresa'   => 'Proveedor Nestlé',
                'nombre_encargado' => 'Elena Vega',
                'direccion'        => 'Calle Nestlé 789, Ciudad L',
                'telefono'         => '5560011223',
                'email'            => 'ventas@proveedornestle.com',
            ],
            [
                'nombre_empresa'   => 'Danone Distribuciones',
                'nombre_encargado' => 'Guillermo Rivas',
                'direccion'        => 'Av. Danone 101, Ciudad M',
                'telefono'         => '5561122334',
                'email'            => 'contacto@danonedistribuciones.com',
            ],
            [
                'nombre_empresa'   => 'Quesos Gourmet',
                'nombre_encargado' => 'Lorena Bravo',
                'direccion'        => 'Calle Gourmet 202, Ciudad N',
                'telefono'         => '5562233445',
                'email'            => 'info@quesosgourmet.com',
            ],
            [
                'nombre_empresa'   => 'Lácteos Santa Clara',
                'nombre_encargado' => 'Rafael Domínguez',
                'direccion'        => 'Av. Santa Clara 303, Ciudad O',
                'telefono'         => '5563344556',
                'email'            => 'ventas@lacteossantaclara.com',
            ],
            [
                'nombre_empresa'   => 'Proveedor PIL Andina',
                'nombre_encargado' => 'Marina Castillo',
                'direccion'        => 'Calle Andina 404, Ciudad P',
                'telefono'         => '5564455667',
                'email'            => 'contacto@pilandina.com',
            ],
            [
                'nombre_empresa'   => 'Delizia Supply',
                'nombre_encargado' => 'Héctor Salinas',
                'direccion'        => 'Av. Delizia 505, Ciudad Q',
                'telefono'         => '5565566778',
                'email'            => 'info@deliziasupply.com',
            ],
            [
                'nombre_empresa'   => 'Artesanal Quesos',
                'nombre_encargado' => 'Patricia Gómez',
                'direccion'        => 'Calle Artesanal 606, Ciudad R',
                'telefono'         => '5566677889',
                'email'            => 'ventas@artesanalquesos.com',
            ],
            [
                'nombre_empresa'   => 'Lácteos Sancor',
                'nombre_encargado' => 'Diego Moreno',
                'direccion'        => 'Av. Sancor 707, Ciudad S',
                'telefono'         => '5567788990',
                'email'            => 'contacto@lacteossancor.com',
            ],
            [
                'nombre_empresa'   => 'Quesos Gloria',
                'nombre_encargado' => 'Verónica Díaz',
                'direccion'        => 'Calle Gloria 808, Ciudad T',
                'telefono'         => '5568899001',
                'email'            => 'info@quesosgloria.com',
            ],
            [
                'nombre_empresa'   => 'Yogures Yoplait',
                'nombre_encargado' => 'Fabián López',
                'direccion'        => 'Av. Yoplait 909, Ciudad U',
                'telefono'         => '5569900112',
                'email'            => 'ventas@yoguresyoplait.com',
            ],
            [
                'nombre_empresa'   => 'Proveedor Lala',
                'nombre_encargado' => 'Carolina Peña',
                'direccion'        => 'Calle Lala 1010, Ciudad V',
                'telefono'         => '5570011223',
                'email'            => 'contacto@proveedorlala.com',
            ],
            [
                'nombre_empresa'   => 'Parmalat Distribuciones',
                'nombre_encargado' => 'Emilio Rojas',
                'direccion'        => 'Av. Parmalat 1111, Ciudad W',
                'telefono'         => '5571122334',
                'email'            => 'info@parmalatdistribuciones.com',
            ],
            [
                'nombre_empresa'   => 'Lácteos Danone',
                'nombre_encargado' => 'Silvia Romero',
                'direccion'        => 'Calle Danone 1212, Ciudad X',
                'telefono'         => '5572233445',
                'email'            => 'ventas@lacteosdanone.com',
            ],
            [
                'nombre_empresa'   => 'Proveedor Gloria',
                'nombre_encargado' => 'Víctor Morales',
                'direccion'        => 'Av. Gloria 1313, Ciudad Y',
                'telefono'         => '5573344556',
                'email'            => 'contacto@proveedorgloria.com',
            ],
            [
                'nombre_empresa'   => 'Quesos Santa Clara',
                'nombre_encargado' => 'Patricio Suárez',
                'direccion'        => 'Calle Santa Clara 1414, Ciudad Z',
                'telefono'         => '5574455667',
                'email'            => 'info@quesossantaclara.com',
            ],
            [
                'nombre_empresa'   => 'Delizia Lácteos',
                'nombre_encargado' => 'Mariana Herrera',
                'direccion'        => 'Av. Delizia 1515, Ciudad AA',
                'telefono'         => '5575566778',
                'email'            => 'ventas@delizialacteos.com',
            ],
            [
                'nombre_empresa'   => 'Artesanal Distribuciones',
                'nombre_encargado' => 'Óscar Vargas',
                'direccion'        => 'Calle Artesanal 1616, Ciudad BB',
                'telefono'         => '5576677889',
                'email'            => 'contacto@artesanaldistribuciones.com',
            ],
            [
                'nombre_empresa'   => 'Proveedor Lacteos Bolivia',
                'nombre_encargado' => 'Andrea Castro',
                'direccion'        => 'Av. Bolivia 1717, Ciudad CC',
                'telefono'         => '5577788990',
                'email'            => 'info@lacteosbolivia.com',
            ],
            [
                'nombre_empresa'   => 'Distribuidora Quesos & Lácteos',
                'nombre_encargado' => 'Fernando Ruiz',
                'direccion'        => 'Calle Distribuidora 1818, Ciudad DD',
                'telefono'         => '5578899001',
                'email'            => 'ventas@quesosylacteos.com',
            ],
        ];

        foreach ($proveedores as $proveedor) {
            Proveedor::create($proveedor);
        }
    }
}
