<?php

use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [WalletController::class, 'index'])->name('dashboard');
});

require __DIR__.'/settings.php';
