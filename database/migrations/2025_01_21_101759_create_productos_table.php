<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('url_imagen')->nullable();
            $table->decimal('precio_venta', 10, 2);
            $table->integer('stock_minimo')->default(0);
            
            // Relación con la tabla categorias
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            
            // Relación con la tabla marcas
            $table->foreignId('marca_id')->constrained('marcas')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
