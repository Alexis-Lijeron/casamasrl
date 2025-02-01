<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            PermisoSeeder::class,
            RolPermisoSeeder::class,
            UsuarioSeeder::class,
            UsuarioRolSeeder::class,
            ClienteSeeder::class,
            ProveedorSeeder::class,
            CategoriaSeeder::class,
            MarcaSeeder::class,
            AlmacenSeeder::class,
            ProductoSeeder::class,
            CompraSeeder::class,
            DetalleCompraSeeder::class,
            MetodoPagoSeeder::class,
            PagoSeeder::class,
            VentaSeeder::class,
            DetalleVentaSeeder::class,

        ]);
    }
}
