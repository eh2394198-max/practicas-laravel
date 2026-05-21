<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->sentence();

        return [
            'name' => $name,             // Cambiado de 'title' a 'name'
            'slug' => Str::slug($name),   // Añadido para evitar errores de integridad
            'extract' => $this->faker->text(250),
            'body' => $this->faker->paragraphs(5, true), // Cambiado de 'content' a 'body'
            'status' => $this->faker->randomElement([1, 2]),
            'category_id' => Category::all()->random()->id ?? Category::factory(),
            'user_id' => User::all()->random()->id ?? User::factory(),
        ];
    }

    // Estados mejorados para consistencia
    public function published()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 2,
        ]);
    }

    public function draft()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 1,
        ]);
    }
}