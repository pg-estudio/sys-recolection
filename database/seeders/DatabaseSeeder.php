<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TipoResiduo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'jrohatan@poligran.edu.co',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'telefono' => '31030631680',
            'direccion' => 'Dirección de Administrador'
        ]);

        // Tipos de Residuos Orgánicos
        TipoResiduo::create([
            'nombre' => 'Fracción Orgánica (FO)',
            'descripcion' => 'Restos de alimentos y cocina: cáscaras de frutas, restos de frutos secos, espinas de pescado, huesos de carne y pollo, cáscaras de huevos, tapones de corcho, papel de cocina.',
            'puntos_por_kilo' => 5,
            'color' => '#8B4513'
        ]);

        TipoResiduo::create([
            'nombre' => 'Fracción Vegetal (FV)',
            'descripcion' => 'Restos vegetales de pequeño tamaño no leñosos: malas hierbas, hojas secas, raíces secas, pequeñas ramas.',
            'puntos_por_kilo' => 4,
            'color' => '#228B22'
        ]);

        TipoResiduo::create([
            'nombre' => 'Residuos de Poda',
            'descripcion' => 'Restos vegetales de mayor tamaño: troncos, ramas grandes, tierra en cantidad.',
            'puntos_por_kilo' => 3,
            'color' => '#006400'
        ]);

        // Residuos Inorgánicos Reciclables
        TipoResiduo::create([
            'nombre' => 'Papel y Cartón',
            'descripcion' => 'Papel y cartón limpios y no contaminados.',
            'puntos_por_kilo' => 8,
            'color' => '#4169E1'
        ]);

        TipoResiduo::create([
            'nombre' => 'Plásticos',
            'descripcion' => 'Plásticos limpios y no contaminados.',
            'puntos_por_kilo' => 10,
            'color' => '#FFD700'
        ]);

        TipoResiduo::create([
            'nombre' => 'Vidrio',
            'descripcion' => 'Vidrio limpio y no contaminado.',
            'puntos_por_kilo' => 6,
            'color' => '#32CD32'
        ]);

        TipoResiduo::create([
            'nombre' => 'Metales',
            'descripcion' => 'Metales limpios y no contaminados.',
            'puntos_por_kilo' => 12,
            'color' => '#808080'
        ]);

        // Residuos Peligrosos
        TipoResiduo::create([
            'nombre' => 'Baterías y Pilas',
            'descripcion' => 'Baterías y pilas que contienen metales pesados (mercurio, cadmio, plomo).',
            'puntos_por_kilo' => 15,
            'color' => '#FF0000'
        ]);

        TipoResiduo::create([
            'nombre' => 'Aceites Usados',
            'descripcion' => 'Aceites de cocina y aceites de motor usados.',
            'puntos_por_kilo' => 10,
            'color' => '#8B0000'
        ]);
    }
}
