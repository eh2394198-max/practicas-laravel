<?php

use App\Http\Controllers\ProfileController; // No olvides esta línea al principio
use Illuminate\Support\Facades\Route;

// Rutas de perfil (Añade esto)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas que requieren autenticación y verificación
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard - Solo admin y editor
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor')->name('dashboard');

    // Crear posts - Solo admin y editor
    Route::post('/posts', function () {
        return 'Post creado';
    })->middleware('role:admin,editor')->name('posts.store');

    // Eliminar posts - Solo admin
    Route::delete('/posts/{id}', function ($id) {
        return "Post {$id} eliminado";
    })->middleware('role:admin')->name('posts.destroy');
});

require __DIR__.'/auth.php';