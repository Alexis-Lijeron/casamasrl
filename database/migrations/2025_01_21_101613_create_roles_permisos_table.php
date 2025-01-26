<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles_permisos', function (Blueprint $table) {
            $table->id();
            
            // Relación con la tabla roles
            $table->foreignId('rol_id')->constrained('roles')->onDelete('cascade');
            
            // Relación con la tabla permisos
            $table->foreignId('permiso_id')->constrained('permisos')->onDelete('cascade');
            
            // Relación con la tabla usuarios
            // $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            
            $table->unique(['rol_id', 'permiso_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles_permisos');
    }
};
