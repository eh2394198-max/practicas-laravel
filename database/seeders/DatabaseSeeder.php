<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Esto imprimirá un mensaje en tu terminal para confirmar que entró aquí
        $this->command->info('--- ENTRANDO AL SEEDER PRINCIPAL ---');

        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
        ]);

        $this->command->info('--- CATEGORIAS Y TAGS LISTOS ---');

        User::factory()->create([
            'name' => 'Emmanuel',
            'email' => 'emmanuel@gmail.com',
        ]);

        User::factory(9)->create();
        
        $this->command->info('--- USUARIOS CREADOS ---');

        Post::factory(50)->create()->each(function ($post) {
            $post->tags()->attach([
                rand(1, 2),
                rand(3, 4)
            ]);
        });

        $this->command->info('--- TODO TERMINÓ CON ÉXITO ---');
    }
}