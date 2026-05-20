<?php

namespace Database\Seeders;

use App\Models\Category; // Importamos el modelo aquí
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Desarrollo Web',
            'slug' => 'desarrollo-web'
        ]);

        Category::create([
            'name' => 'Diseño Gráfico',
            'slug' => 'diseno-grafico'
        ]);

        Category::create([
            'name' => 'Programación',
            'slug' => 'programacion'
        ]);
    }
}