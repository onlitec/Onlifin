<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Settings\SystemSettings;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Dashboard;

// Rotas públicas
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

// Rotas de autenticação
Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    
    // Rotas de recuperação de senha
    Route::get('forgot-password', \App\Livewire\Auth\ForgotPassword::class)->name('password.request');
    Route::get('reset-password/{token}', \App\Livewire\Auth\ResetPassword::class)->name('password.reset');
});

// Rotas protegidas
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Rotas de Despesas
    Route::get('/expenses', \App\Livewire\Expenses\ExpenseList::class)->name('expenses.index');
    
    // Rotas de Receitas
    Route::get('/incomes', \App\Livewire\Incomes\IncomeList::class)->name('incomes.index');

    // Rotas de admin
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/settings', SystemSettings::class)->name('settings');
    });
});

// Rota de logout
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');
