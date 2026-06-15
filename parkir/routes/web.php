<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/locations');

Route::resource('locations', LocationController::class);
Route::resource('vehicletypes', VehicleTypeController::class);
Route::post('transactions/exit', [TransactionController::class, 'exit'])->name('transactions.exit');
Route::resource('transactions', TransactionController::class);

Route::get('transactions/{no_tiket}/print', [TransactionController::class, 'print'])->name('transactions.print');

Route::resource('transactions', TransactionController::class);