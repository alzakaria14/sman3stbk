<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsContentImageController;
use App\Http\Controllers\Admin\NewsPostController as AdminNewsPostController;
use App\Http\Controllers\Admin\SchoolSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/profil', ProfileController::class)->name('profile');
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{newsPost:slug}', [NewsController::class, 'show'])->name('news.show');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AuthController::class, 'create'])->name('login');
        Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    });

    Route::post('/logout', [AuthController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/settings', [SchoolSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SchoolSettingController::class, 'update'])->name('settings.update');
        Route::post('/news/content-images', NewsContentImageController::class)->name('news.content-images.store');
        Route::resource('news', AdminNewsPostController::class)->except(['show']);
    });
});
