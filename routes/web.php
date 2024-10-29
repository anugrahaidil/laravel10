<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\Auth\LoginRegisterController;


Route::middleware(['auth'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
    Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::post('/buku/{id}/update', [BukuController::class, 'update'])->name('buku.update');
    Route::resource('buku', BukuController::class)->except(['index']);
});
// Routes untuk autentikasi dan dashboard
Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
    // Dashboard user biasa
    Route::get('/dashboard', 'dashboard')->name('user.dashboard')->middleware('auth');
});
// Dashboard admin dengan middleware khusus
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [LoginRegisterController::class, 'dashboard'])->name('admin.dashboard');
});

Route::get('restricted', function () {
    return "Anda berusia lebih dari 18 tahun!";
})->middleware('checkage');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
