<?php

namespace Database\Seeders;

use App\Models\ProductoAlmacen;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductoAlmacenSeeder extends Seeder
{
    public function run(): void
    {
        $registros = [
            [
                'producto_id'      => 1,
                'almacen_id'       => 1,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(90)->toDateString(),
            ],
            [
                'producto_id'      => 2,
                'almacen_id'       => 1,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(120)->toDateString(),
            ],
            [
                'producto_id'      => 3,
                'almacen_id'       => 2,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(180)->toDateString(),
            ],
            [
                'producto_id'      => 4,
                'almacen_id'       => 2,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(60)->toDateString(),
            ],
            [
                'producto_id'      => 5,
                'almacen_id'       => 3,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(150)->toDateString(),
            ],
            [
                'producto_id'      => 6,
                'almacen_id'       => 3,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(200)->toDateString(),
            ],
            [
                'producto_id'      => 7,
                'almacen_id'       => 4,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(75)->toDateString(),
            ],
            [
                'producto_id'      => 8,
                'almacen_id'       => 4,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(90)->toDateString(),
            ],
            [
                'producto_id'      => 9,
                'almacen_id'       => 5,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(30)->toDateString(),
            ],
            [
                'producto_id'      => 10,
                'almacen_id'       => 5,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(365)->toDateString(),
            ],
            [
                'producto_id'      => 11,
                'almacen_id'       => 6,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(100)->toDateString(),
            ],
            [
                'producto_id'      => 12,
                'almacen_id'       => 6,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(80)->toDateString(),
            ],
            [
                'producto_id'      => 13,
                'almacen_id'       => 7,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(150)->toDateString(),
            ],
            [
                'producto_id'      => 14,
                'almacen_id'       => 7,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(210)->toDateString(),
            ],
            [
                'producto_id'      => 15,
                'almacen_id'       => 8,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(95)->toDateString(),
            ],
            [
                'producto_id'      => 16,
                'almacen_id'       => 8,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(130)->toDateString(),
            ],
            [
                'producto_id'      => 17,
                'almacen_id'       => 9,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(180)->toDateString(),
            ],
            [
                'producto_id'      => 18,
                'almacen_id'       => 9,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(60)->toDateString(),
            ],
            [
                'producto_id'      => 19,
                'almacen_id'       => 10,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(45)->toDateString(),
            ],
            [
                'producto_id'      => 20,
                'almacen_id'       => 10,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(150)->toDateString(),
            ],
            [
                'producto_id'      => 21,
                'almacen_id'       => 1,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(75)->toDateString(),
            ],
            [
                'producto_id'      => 22,
                'almacen_id'       => 2,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(90)->toDateString(),
            ],
            [
                'producto_id'      => 23,
                'almacen_id'       => 3,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(120)->toDateString(),
            ],
            [
                'producto_id'      => 24,
                'almacen_id'       => 4,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(200)->toDateString(),
            ],
            [
                'producto_id'      => 25,
                'almacen_id'       => 5,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(250)->toDateString(),
            ],
            [
                'producto_id'      => 26,
                'almacen_id'       => 6,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(40)->toDateString(),
            ],
            [
                'producto_id'      => 27,
                'almacen_id'       => 7,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(180)->toDateString(),
            ],
            [
                'producto_id'      => 28,
                'almacen_id'       => 8,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(90)->toDateString(),
            ],
            [
                'producto_id'      => 29,
                'almacen_id'       => 9,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(110)->toDateString(),
            ],
            [
                'producto_id'      => 30,
                'almacen_id'       => 10,
                'stock'            => 0,
                'fecha_vencimiento' => Carbon::now()->addDays(130)->toDateString(),
            ],
        ];

        foreach ($registros as $registro) {
            ProductoAlmacen::create($registro);
        }
    }
}
