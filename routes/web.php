<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

# Public Routes
Route::get('/', [PublicEventController::class, 'index'])->name('home');
Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('events.show');
Route::post('/events/{event}/register', [PublicEventController::class, 'register'])->name('events.register');

# Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

# Admin Routes (auth required)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('events', EventController::class);
    Route::resource('participants', ParticipantController::class);
    Route::resource('registrations', RegistrationController::class);
});
