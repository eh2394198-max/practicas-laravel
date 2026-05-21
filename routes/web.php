<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes - PRÁCTICA 3 (MANEJO DE ARCHIVOS)
|--------------------------------------------------------------------------
*/

// 1. RUTAS DE GESTIÓN (CRUD)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard con acceso para todos los roles
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor,view')->name('dashboard');

    // Rutas protegidas para Admin y Editor (PRÁCTICA 3)
    Route::middleware('role:admin,editor')->group(function () {
        Route::resource('posts', PostController::class)->except(['index', 'show']);
        
        // PASO 6: Ruta para eliminar archivos individuales 
        Route::delete('attachments/{attachment}', [PostController::class, 'destroyAttachment'])->name('attachments.destroy');
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

// 3. DETALLE DE POST
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

// 4. LOGOUT MANUAL
Route::get('/logout-manual', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout.manual');

require __DIR__.'/auth.php';