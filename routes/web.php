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
    
    // Users Management
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/users/export-csv', [\App\Http\Controllers\UserController::class, 'exportCsv'])->name('users.export-csv');
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });

    // Medical Records
    Route::middleware(['role:Admin,Weterynarz'])->group(function () {
        Route::get('/medical-records/{animal}/pdf', [App\Http\Controllers\MedicalRecordController::class, 'exportPdf'])->name('medical-records.export-pdf');
        Route::get('/medical-records', [App\Http\Controllers\MedicalRecordController::class, 'index'])->name('medical-records.index');
        Route::post('/medical-records', [App\Http\Controllers\MedicalRecordController::class, 'store'])->name('medical-records.store');
        Route::patch('/medical-records/{record}', [App\Http\Controllers\MedicalRecordController::class, 'update'])->name('medical-records.update');
        Route::delete('/medical-records/{record}', [App\Http\Controllers\MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');
    });
    
    // Volunteer Tasks
    Route::middleware(['role:Admin,Weterynarz,Pracownik,Wolontariusz'])->group(function () {
        Route::get('/volunteer-tasks', [App\Http\Controllers\VolunteerTaskController::class, 'index'])->name('volunteer-tasks.index');
        Route::post('/volunteer-tasks', [App\Http\Controllers\VolunteerTaskController::class, 'store'])->name('volunteer-tasks.store');
        Route::patch('/volunteer-tasks/{task}', [App\Http\Controllers\VolunteerTaskController::class, 'update'])->name('volunteer-tasks.update');
        Route::delete('/volunteer-tasks/{task}', [App\Http\Controllers\VolunteerTaskController::class, 'destroy'])->name('volunteer-tasks.destroy');
    });

    // Adoption Applications
    Route::post('/adoption-applications', [\App\Http\Controllers\AdoptionApplicationController::class, 'store'])->name('adoption-applications.store');
    
    // User specific routes for adoption applications
    Route::get('/moje-wnioski', [\App\Http\Controllers\AdoptionApplicationController::class, 'myApplications'])->name('user.adoption-applications.index');
    Route::get('/moje-wnioski/{application}', [\App\Http\Controllers\AdoptionApplicationController::class, 'showMyApplication'])->name('user.adoption-applications.show');

    Route::middleware(['role:Admin,Pracownik'])->group(function () {
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
