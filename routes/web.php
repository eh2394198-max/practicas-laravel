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

// 1. RUTAS DE GESTIÓN (CRUD) - DEBEN IR ARRIBA PARA EVITAR EL 404
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard con acceso para todos los roles
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor,view')->name('dashboard');

    // Rutas protegidas para Admin y Editor
    Route::middleware('role:admin,editor')->group(function () {
        // Al poner el resource aquí arriba, Laravel encontrará 'posts/create' antes que 'posts/{post}'
        Route::resource('posts', PostController::class)->except(['index', 'show']);
    });

    // Perfil de usuario
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

// 2. PÁGINA PRINCIPAL Y FILTROS (Públicos)
Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('category/{category}', [PostController::class, 'category'])->name('posts.category');
Route::get('tag/{tag}', [PostController::class, 'tag'])->name('posts.tag');

// 3. DETALLE DE POST - ESTA DEBE IR AL FINAL
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

// 4. LOGOUT MANUAL
Route::get('/logout-manual', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout.manual');

require __DIR__.'/auth.php';