<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\Admin\AuditController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Versión Práctica 5 (Con Panel Administrativo)
|--------------------------------------------------------------------------
*/

// --- 1. RUTAS PÚBLICAS (BLOG) ---
Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::get('/posts', [PostController::class, 'index']);

Route::get('posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');

Route::get('category/{category}', [PostController::class, 'category'])
    ->name('posts.category');

Route::get('tag/{tag}', [PostController::class, 'tag'])
    ->name('posts.tag');


// DASHBOARD GENERAL
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// --- 2. RUTAS PROTEGIDAS ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Perfil
    Route::controller(ProfileController::class)->group(function () {

        Route::get('/profile', 'edit')
            ->name('profile.edit');

        Route::patch('/profile', 'update')
            ->name('profile.update');

        Route::delete('/profile', 'destroy')
            ->name('profile.destroy');
    });

    // --- 3. PANEL ADMIN ---
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Posts Admin
        Route::resource('/posts', PostAdminController::class);

        // Auditoría
        Route::resource('/audits', AuditController::class)
            ->only(['index', 'show']);
    });

    // --- 4. POSTS ADMIN Y EDITOR ---
    Route::middleware('role:admin,editor')->group(function () {

        Route::resource('posts', PostController::class)
            ->except(['index', 'show']);

        Route::delete('attachments/{attachment}', [PostController::class, 'destroyAttachment'])
            ->name('attachments.destroy');
    });
});

require __DIR__.'/auth.php';