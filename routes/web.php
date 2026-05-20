<?php

use Illuminate\Support\Facades\Route;

// Rutas que requieren autenticación y verificación
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard - Solo admin y editor
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor')->name('dashboard');

    // Crear posts - Solo admin y editor
    Route::post('/posts', function () {

        // Lógica para guardar post

        return 'Post creado';

    })->middleware('role:admin,editor')->name('posts.store');

    // Eliminar posts - Solo admin
    Route::delete('/posts/{id}', function ($id) {

        // Lógica para eliminar post

        return "Post {$id} eliminado";

    })->middleware('role:admin')->name('posts.destroy');

});

require __DIR__.'/auth.php';