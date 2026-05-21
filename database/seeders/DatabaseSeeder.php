<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear usuario admin
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Asignar rol admin
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        $admin->roles()->attach($adminRole);

        // 3. Crear más usuarios (10 adicionales)
        $users = \App\Models\User::factory(10)->create();

        // 4. Asignar rol editor a 5 usuarios aleatorios
        $editorRole = \App\Models\Role::where('name', 'editor')->first();
        $users->random(5)->each(function ($user) use ($editorRole) {
            $user->roles()->attach($editorRole);
        });

        // 5. Crear categorías
        $categories = \App\Models\Category::factory(5)->create();

        // 6. Crear 50 posts con relaciones complejas
        \App\Models\Post::factory(50)
            ->recycle($users)       // Asigna autores de los usuarios creados
            ->recycle($categories)  // Asigna categorías de las creadas
            ->create()
            ->each(function ($post) {
                // Agregar 3 tags aleatorios por post
                $tags = \App\Models\Tag::factory(3)->create();
                $post->tags()->attach($tags);

                // Agregar 5 comentarios por cada post
                \App\Models\Comment::factory(5)
                    ->for($post)
                    ->create();
            });
    }
}