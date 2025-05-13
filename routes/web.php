<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NewsController;

Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::resource('services', ServiceController::class);
});

Route::get('/public', [ServiceController::class, 'public'])->name('public');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::get('/profile/password', [ProfileController::class, 'passwordForm'])->name('profile.password.form');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');


Route::resource('news', NewsController::class)->middleware('auth');
