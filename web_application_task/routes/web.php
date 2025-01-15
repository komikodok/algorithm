<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, 'index'])->name('users');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.delete');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::get('/users-data', [UserController::class, 'getUsersData'])->name('users.data');
Route::post('/users-store', [UserController::class, 'store'])->name('users.store');

// Route::get('/', function () {
//     return view('welcome');
// });
