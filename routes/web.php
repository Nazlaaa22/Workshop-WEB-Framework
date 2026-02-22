<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfController;

Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::resource('kategori', App\Http\Controllers\KategoriController::class);
    Route::resource('buku', App\Http\Controllers\BukuController::class);
});

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/otp', [\App\Http\Controllers\AuthController::class, 'showOtpForm']);
Route::post('/verify-otp', [\App\Http\Controllers\AuthController::class, 'verifyOtp']);

Route::get('/pdf-sertifikat', [PdfController::class, 'sertifikat']);
Route::get('/pdf-undangan', [PdfController::class, 'undangan']);