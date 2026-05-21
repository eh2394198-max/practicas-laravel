<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;

// Controladores Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\Admin\AuditController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí registramos todas las rutas de la aplicación.
|
*/


/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS DEL BLOG
|--------------------------------------------------------------------------
*/

// Página principal
Route::get('/', [PostController::class, 'index'])
    ->name('posts.index');

// Listado de posts
Route::get('/posts', [PostController::class, 'index']);

// Mostrar un post
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');

// Filtrar por categoría
Route::get('/category/{category}', [PostController::class, 'category'])
    ->name('posts.category');

// Filtrar por tags
Route::get('/tag/{tag}', [PostController::class, 'tag'])
    ->name('posts.tag');


/*
|--------------------------------------------------------------------------
| 2. DASHBOARD GENERAL
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
  ->name('dashboard');


/*
|--------------------------------------------------------------------------
| 3. RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::controller(ProfileController::class)->group(function () {

        Route::get('/profile', 'edit')
            ->name('profile.edit');

        Route::patch('/profile', 'update')
            ->name('profile.update');

        Route::delete('/profile', 'destroy')
            ->name('profile.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | 4. PANEL ADMINISTRATIVO
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Gestión de Posts Admin
        Route::resource('/posts', PostAdminController::class);

        // Auditoría
        Route::resource('/audits', AuditController::class)
            ->only(['index', 'show']);
    });


    /*
    |--------------------------------------------------------------------------
    | 5. POSTS PARA ADMIN Y EDITOR
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:admin,editor'])->group(function () {

        Route::resource('posts', PostController::class)
            ->except(['index', 'show']);

        Route::delete(
            'attachments/{attachment}',
            [PostController::class, 'destroyAttachment']
        )->name('attachments.destroy');
    });
});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';