<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
// use App\Http\Controllers\MitraController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\PetugasKegiatanController;

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

Route::resource('/tabel-kegiatan', KegiatanController::class)->except('show')->middleware('auth');
Route::get('/tabel-kegiatan/{kegiatan:slug}', [KegiatanController::class, 'show'])->middleware('auth');

Route::get('/tabel-penugasan', [PetugasKegiatanController::class, 'index'])->middleware('auth');
Route::post('/petugas-import', [PetugasKegiatanController::class, 'import'])->name('petugas-import')->middleware('auth');

// Route::get('/tabel-penugasan/{penugasan:slug}', [PenugasanController::class, 'show'])->middleware('auth');

// Route::get('/mitra', [MitraController::class, 'index'])->middleware('auth');
