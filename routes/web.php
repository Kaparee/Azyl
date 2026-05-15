<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Adoption Applications
    Route::post('/adoption-applications', [\App\Http\Controllers\AdoptionApplicationController::class, 'store'])->name('adoption-applications.store');
    
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin/adoption-applications', [\App\Http\Controllers\AdoptionApplicationController::class, 'index'])->name('admin.adoption-applications.index');
        Route::get('/admin/adoption-applications/{application}', [\App\Http\Controllers\AdoptionApplicationController::class, 'show'])->name('admin.adoption-applications.show');
        Route::patch('/admin/adoption-applications/{application}', [\App\Http\Controllers\AdoptionApplicationController::class, 'update'])->name('admin.adoption-applications.update');
    });
});

require __DIR__.'/auth.php';
