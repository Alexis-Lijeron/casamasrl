<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nota_ventas', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto_total', 10, 2);
            $table->dateTime('fecha_venta');
            $table->decimal('descuento', 10, 2)->nullable()->default(0);

            // Relación con la tabla clientes
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            
            // Relación con la tabla usuarios
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            
            // Relación con la tabla pagos
            // $table->foreignId('pago_id')->constrained('pagos')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_ventas');
    }
};
