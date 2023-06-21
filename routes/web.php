<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::resource('customers', CustomerController::class);
Route::post('customers/multipleUpdate', [CustomerController::class, 'multipleUpdate'])->name('customers.multipleUpdate');
Route::post('customers/multipleDelete', [CustomerController::class, 'multipleDelete'])->name('customers.multipleDelete');

