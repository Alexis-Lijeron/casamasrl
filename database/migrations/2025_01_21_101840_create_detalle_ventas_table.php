<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->decimal('precio_venta', 10, 2);
            
            // Relación con la tabla ventas
            $table->foreignId('venta_id')->constrained('nota_ventas')->onDelete('cascade');
            
            // Relación con la tabla producto almacen
            $table->foreignId('producto_almacen_id')->constrained('producto_almacen')->onDelete('cascade');
            
            $table->unique(['venta_id', 'producto_almacen_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas');
    }
};
