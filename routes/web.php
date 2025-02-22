<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use App\Livewire\Expenses\ExpenseList;
use App\Livewire\Incomes\IncomeList;
use Livewire\Volt\Volt;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::view('/', 'welcome');

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    
    // Rotas de Despesas
    Route::get('/expenses', ExpenseList::class)->name('expenses.index');
    
    // Rotas de Receitas
    Route::get('/incomes', IncomeList::class)->name('incomes.index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/settings', App\Livewire\Settings\SystemSettings::class)->name('settings');
});

// Rota de logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php';
