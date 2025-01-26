<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->dateTime('fecha_devolucion');
            $table->decimal('monto_total', 10, 2);
            
            // Relación con la tabla usuarios
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            
            // Relación con la tabla nota compras
            $table->foreignId('compra_id')->constrained('nota_compras')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
