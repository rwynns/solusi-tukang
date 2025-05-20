<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JasaController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TukangController;
use App\Http\Controllers\SubJasaController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TukangDashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jasa/{jasa}', [HomeController::class, 'jasaDetail'])->name('jasa.detail');
Route::get('/api/sub-jasa/{subJasa}', [HomeController::class, 'getSubJasaDetail']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('skills', SkillController::class);
        Route::resource('locations', LocationController::class);
        Route::resource('tukang', TukangController::class);
        Route::resource('kelola-jasa', JasaController::class)->parameters(['kelola-jasa' => 'jasa']);
        Route::resource('sub-jasa', SubJasaController::class);
    });

    Route::middleware(['tukang'])->group(function () {
        Route::get('/dashboard-tukang', [TukangDashboardController::class, 'index'])->name('tukang.dashboard');
        Route::get('/profile', [TukangDashboardController::class, 'showProfile'])->name('profile');
        Route::get('/profile/edit', [TukangDashboardController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/update', [TukangDashboardController::class, 'updateProfile'])->name('profile.update');
    });
});
