<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Importante para usar el modelo

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos los tres roles básicos definidos en la práctica
        Role::create(['name' => 'admin']); 
        Role::create(['name' => 'editor']); 
        Role::create(['name' => 'viewer']); 
    }
}