<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;
use App\Models\MetodoPago;

class MetodoPagoSeeder extends Seeder
{
    public function run(): void
    {
        // Deshabilita temporalmente las restricciones de clave foránea
        Schema::disableForeignKeyConstraints();
        MetodoPago::truncate(); // Limpia la tabla antes de insertar
        Schema::enableForeignKeyConstraints();

        // Inserta los métodos de pago
        MetodoPago::insert([
            ['nombre' => 'Efectivo', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Qr', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tarjeta de Débito', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tarjeta de Credito', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
