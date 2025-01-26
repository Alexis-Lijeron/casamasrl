<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ajuste_inventarios', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha');
            $table->string('tipo');
            $table->text('descripcion')->nullable();
            
            // Relación con usuarios
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ajuste_inventarios');
    }
};
