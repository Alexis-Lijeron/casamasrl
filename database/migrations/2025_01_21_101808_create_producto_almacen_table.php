<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto_almacen', function (Blueprint $table) {
            $table->id();
            $table->integer('stock')->default(0);
            $table->dateTime('fecha_vencimiento')->nullable();
            
            // Relación con la tabla producto
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            
            // Relación con la tabla almacen
            $table->foreignId('almacen_id')->constrained('almacenes')->onDelete('cascade');
            
            $table->unique(['producto_id', 'almacen_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_almacen');
    }
};
