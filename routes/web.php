<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes - PRÁCTICA 2 (BLOG)
|--------------------------------------------------------------------------
*/

// 1. PÁGINA PRINCIPAL
Route::get('/', [PostController::class, 'index'])->name('posts.index');

// 2. DETALLE DE POST Y FILTROS
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('category/{category}', [PostController::class, 'category'])->name('posts.category');
Route::get('tag/{tag}', [PostController::class, 'tag'])->name('posts.tag');

// 3. RUTAS PROTEGIDAS POR AUTENTICACIÓN
Route::middleware(['auth', 'verified'])->group(function () {

    // CORRECCIÓN: Agregamos 'view' para que Ibarra no vea el error 403
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor,view')->name('dashboard');

    // RUTAS DE GESTIÓN (CRUD): Solo Admin y Editor pueden entrar aquí
    // Esto protege que un 'view' no pueda crear o editar aunque escriba la URL
    Route::middleware('role:admin,editor')->group(function () {
        Route::resource('posts', PostController::class)->except(['index', 'show']);
    });

    // Rutas del perfil de usuario
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

// 4. LOGOUT MANUAL
Route::get('/logout-manual', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout.manual');

require __DIR__.'/auth.php';