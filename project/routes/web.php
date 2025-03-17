<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Rotas de autenticação
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Transações
    Route::prefix('transactions')->name('transactions.')->group(function () {
        // Depósito
        Route::get('/deposit', [TransactionController::class, 'showDepositForm'])->name('deposit.form');
        Route::post('/deposit', [TransactionController::class, 'deposit'])->name('deposit');
        
        // Transferência
        Route::get('/transfer', [TransactionController::class, 'showTransferForm'])->name('transfer.form');
        Route::post('/transfer', [TransactionController::class, 'transfer'])->name('transfer');
        
        // Histórico
        Route::get('/history', [TransactionController::class, 'history'])->name('history');
        
        // Reversão
        Route::post('/reverse/{transaction}', [TransactionController::class, 'reverse'])->name('reverse');
    });
});
