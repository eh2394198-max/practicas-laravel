<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// Usamos el modelo de la librería para evitar errores de guard_name
use Spatie\Permission\Models\Role; 

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        /* Usamos firstOrCreate para que si los roles ya existen 
           (como los que creamos en Tinker), el seeder no explote.
        */

        // 1. El Admin: Control total
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']); 

        // 2. El Editor: Puede crear y editar, pero no borrar (típico de blogs)
        Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']); 

        // 3. El View: Solo entra a mirar (el que le dimos a Emmanuel Ibarra)
        Role::firstOrCreate(['name' => 'view', 'guard_name' => 'web']); 
    }
}