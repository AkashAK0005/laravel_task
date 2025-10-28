<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/show/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('/user/export-csv', [UserController::class, 'exportCSV'])->name('user.exportCSV');
Route::get('/user/export-pdf', [UserController::class, 'exportPDF'])->name('user.exportPDF');