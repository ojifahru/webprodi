<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\FacilitiesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LecturersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tentang', [AboutController::class, 'index'])->name('about');

Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/fasilitas', [FacilitiesController::class, 'index'])->name('facilities.index');
Route::get('/fasilitas/{facility}', [FacilitiesController::class, 'show'])->name('facilities.show');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');

Route::get('/dosen/{lecturer}', [LecturersController::class, 'show'])->name('lecturers.show');
