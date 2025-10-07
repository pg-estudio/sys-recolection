<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tipo_residuo_id')->constrained('tipos_residuos')->onDelete('cascade');
            $table->foreignId('ruta_id')->nullable()->constrained('rutas')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'confirmada', 'recolectada'])->default('cancelada');
            $table->decimal('peso', 6, 2)->nullable();
            $table->integer('puntos_ganados')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
