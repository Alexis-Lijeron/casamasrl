<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nota_compras', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto_total', 10, 2);
            $table->dateTime('fecha_compra');
            $table->boolean('estado')->default(false);
            
            // Relación con la tabla proveedores
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            
            // Relación con la tabla usuarios
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            
            // Relación con la tabla pagos
            // $table->foreignId('pago_id')->constrained('pagos')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_compras');
    }
};
