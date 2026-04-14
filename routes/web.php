<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController; // Importado
use Illuminate\Support\Facades\Route;

// A Landing Page (Aberta para o público)
Route::get('/', function () {
    return view('welcome');
});

// O Nosso Sistema (Fechado, exige Login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/sala', [DashboardController::class, 'porSala'])->name('dashboard.sala');
    Route::get('/dashboard/dia', [DashboardController::class, 'porDia'])->name('dashboard.dia');

    // Rotas de Gestão de Usuários (Apenas para o Admin)
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    });

// Perfil do Usuário
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update.custom');
    });

require __DIR__.'/auth.php';