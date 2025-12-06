<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Inertia\Inertia;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;

// Guest routes
Route::middleware('guest')->group(function () {
    // Login page
    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');

    // Handle login POST
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard at root "/"
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // --- Albums ---
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::put('/albums/{id}', [AlbumController::class, 'update'])->name('albums.update');
    Route::delete('/albums/{id}', [AlbumController::class, 'destroy'])->name('albums.destroy');

    // --- Artists ---
    Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
    Route::put('/artists/{id}', [ArtistController::class, 'update'])->name('artists.update');
    Route::delete('/artists/{id}', [ArtistController::class, 'destroy'])->name('artists.destroy');
});
