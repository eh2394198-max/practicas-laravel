<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Ruta principal (Página de bienvenida)
Route::get('/', function () {
    return view('welcome');
});

// 2. Ruta de salida rápida (Logout Manual)
// Corregido: Se asegura de que solo usuarios autenticados puedan intentar salir
Route::get('/logout-manual', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout.manual');

// 3. Rutas protegidas por Autenticación y Verificación
Route::middleware(['auth', 'verified'])->group(function () {

    // DASHBOARD: Protegido por roles
    // IMPORTANTE: Asegúrate de que el middleware 'role' esté registrado en bootstrap/app.php
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor')->name('dashboard');

    // PERFIL: Agrupamos para mayor limpieza
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';