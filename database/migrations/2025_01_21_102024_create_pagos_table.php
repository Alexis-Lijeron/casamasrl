<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 10, 2);
            $table->dateTime('fecha_pago');
            $table->text('descripcion')->nullable();
            $table->boolean('estado')->default(false);
            
            // Relación uno a uno con la tabla nota_ventas
            $table->foreignId('venta_id')->constrained('nota_ventas')->onDelete('cascade');
            
            // Relación uno a uno con la tabla compras
            // $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade');
            
            // Relación uno a muchos con la tabla metodos_pagos
            $table->foreignId('metodo_pago_id')->nullable()->constrained('metodo_pagos')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
