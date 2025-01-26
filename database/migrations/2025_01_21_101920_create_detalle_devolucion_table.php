<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_devolucion', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            
            // Relación con la tabla devoluciones
            $table->foreignId('devolucion_id')->constrained('devoluciones')->onDelete('cascade');
            
            // Relación con la tabla producto almacen
            $table->foreignId('producto_almacen_id')->constrained('producto_almacen')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_devolucion');
    }
};
