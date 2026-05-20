<?php

namespace Database\Seeders;

use App\Models\Tag; // Importamos el modelo para no escribir la ruta larga abajo
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Al importar el modelo arriba, el código queda más corto y limpio
        Tag::create(['name' => 'Laravel', 'slug' => 'laravel']);
        Tag::create(['name' => 'PHP', 'slug' => 'php']);
        Tag::create(['name' => 'Vue JS', 'slug' => 'vue-js']);
        Tag::create(['name' => 'Tailwind', 'slug' => 'tailwind']);
    }
}