<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(); // Genera un título al azar

        return [
            'name' => $name,
            'slug' => Str::slug($name), // Convierte "Hola Mundo" en "hola-mundo"
            'extract' => $this->faker->text(250),
            'body' => $this->faker->text(2000),
            'status' => $this->faker->randomElement([1, 2]),
            'category_id' => Category::all()->random()->id, // Toma una categoría existente al azar
            'user_id' => User::all()->random()->id, // Toma un usuario existente al azar
        ];
    }
}