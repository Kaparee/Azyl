<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/o-nas', function () {
    return view('about');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Medical Records
    Route::middleware(['role:Admin,Weterynarz'])->group(function () {
        Route::get('/medical-records', [App\Http\Controllers\MedicalRecordController::class, 'index'])->name('medical-records.index');
        Route::post('/medical-records', [App\Http\Controllers\MedicalRecordController::class, 'store'])->name('medical-records.store');
    });
    
    // Volunteer Tasks
    Route::middleware(['role:Admin,Weterynarz,Pracownik,Wolontariusz'])->group(function () {
        Route::get('/volunteer-tasks', [App\Http\Controllers\VolunteerTaskController::class, 'index'])->name('volunteer-tasks.index');
        Route::post('/volunteer-tasks', [App\Http\Controllers\VolunteerTaskController::class, 'store'])->name('volunteer-tasks.store');
        Route::patch('/volunteer-tasks/{task}', [App\Http\Controllers\VolunteerTaskController::class, 'update'])->name('volunteer-tasks.update');
    });

    // Adoption Applications
    Route::post('/adoption-applications', [\App\Http\Controllers\AdoptionApplicationController::class, 'store'])->name('adoption-applications.store');

    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin/adoption-applications', [\App\Http\Controllers\AdoptionApplicationController::class, 'index'])->name('admin.adoption-applications.index');
        Route::get('/admin/adoption-applications/{application}', [\App\Http\Controllers\AdoptionApplicationController::class, 'show'])->name('admin.adoption-applications.show');
        Route::patch('/admin/adoption-applications/{application}', [\App\Http\Controllers\AdoptionApplicationController::class, 'update'])->name('admin.adoption-applications.update');

        // tutaj dla admina aby se klikał
        Route::post('/admin/fundraisers', [\App\Http\Controllers\FundraiserController::class, 'store'])->name('admin.fundraisers.store');
    });

    Route::get('/fundraisers', [\App\Http\Controllers\FundraiserController::class, 'index'])->name('fundraisers.index');

    Route::get('/fundraisers/{fundraiser}', [\App\Http\Controllers\FundraiserController::class, 'show'])->name('fundraisers.show');

    Route::post('/donations', [\App\Http\Controllers\DonationController::class, 'store'])->name('donation.store');
});

require __DIR__.'/auth.php';
