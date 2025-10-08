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
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->text('descripcion')->after('tipo_residuo_id');
            $table->text('direccion')->after('descripcion');
            $table->decimal('peso_aproximado', 6, 2)->after('direccion');
            $table->date('fecha_preferida')->after('peso_aproximado');
            $table->string('telefono_contacto')->after('fecha_preferida');
            $table->text('notas_adicionales')->nullable()->after('telefono_contacto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropColumn([
                'descripcion',
                'direccion',
                'peso_aproximado',
                'fecha_preferida',
                'telefono_contacto',
                'notas_adicionales',
            ]);
        });
    }
};
