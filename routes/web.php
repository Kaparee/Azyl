<?php

use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Admin\BreedController;
use App\Http\Controllers\Admin\SpeciesController;
use App\Http\Controllers\AdoptionApplicationController;
use App\Http\Controllers\AnimalCatalogController;
use App\Http\Controllers\AnimalLikeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FundraiserController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerTaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// katalog zwierząt i wejście przez token QR.
Route::get('/animals', [AnimalCatalogController::class, 'index'])->name('animals.index');
Route::get('/animals/{animal}', [AnimalCatalogController::class, 'show'])->name('animals.show');
Route::get('/a/{qr_token}', [AnimalCatalogController::class, 'qr'])->name('animals.qr');
Route::get('/o-nas', function () {
    return view('about');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Users Management
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/users/export-csv', [UserController::class, 'exportCsv'])->name('users.export-csv');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Medical Records
    Route::middleware(['role:Admin,Weterynarz'])->group(function () {
        Route::get('/medical-records/{animal}/pdf', [MedicalRecordController::class, 'exportPdf'])->name('medical-records.export-pdf');
        Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
        Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
        Route::patch('/medical-records/{record}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
        Route::delete('/medical-records/{record}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');
    });

    // Volunteer Tasks
    Route::middleware(['role:Admin,Weterynarz,Pracownik,Wolontariusz'])->group(function () {
        Route::get('/volunteer-tasks', [VolunteerTaskController::class, 'index'])->name('volunteer-tasks.index');
        Route::post('/volunteer-tasks', [VolunteerTaskController::class, 'store'])->name('volunteer-tasks.store');
        Route::patch('/volunteer-tasks/{task}', [VolunteerTaskController::class, 'update'])->name('volunteer-tasks.update');
        Route::delete('/volunteer-tasks/{task}', [VolunteerTaskController::class, 'destroy'])->name('volunteer-tasks.destroy');
    });

    Route::post('/animals/{animal}/like', [AnimalLikeController::class, 'toggle'])->name('animals.like');

    // Adoption Applications
    Route::post('/adoption-applications', [AdoptionApplicationController::class, 'store'])->name('adoption-applications.store');

    // User specific routes for adoption applications
    Route::get('/moje-wnioski', [AdoptionApplicationController::class, 'myApplications'])->name('user.adoption-applications.index');
    Route::get('/moje-wnioski/{application}', [AdoptionApplicationController::class, 'showMyApplication'])->name('user.adoption-applications.show');

    Route::middleware(['role:Admin,Pracownik'])->group(function () {
        Route::get('/admin/adoption-applications', [AdoptionApplicationController::class, 'index'])->name('admin.adoption-applications.index');
        Route::get('/admin/adoption-applications/{application}', [AdoptionApplicationController::class, 'show'])->name('admin.adoption-applications.show');
        Route::patch('/admin/adoption-applications/{application}', [AdoptionApplicationController::class, 'update'])->name('admin.adoption-applications.update');

        // tutaj dla admina aby se klikał
        Route::post('/admin/fundraisers', [FundraiserController::class, 'store'])->name('admin.fundraisers.store');
    });

    Route::get('/fundraisers', [FundraiserController::class, 'index'])->name('fundraisers.index');

    Route::get('/fundraisers/{fundraiser}', [FundraiserController::class, 'show'])->name('fundraisers.show');

    Route::post('/donations', [DonationController::class, 'store'])->name('donation.store');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('animals', AnimalController::class)->except(['show']);
        Route::resource('species', SpeciesController::class)->except(['show']);
        Route::resource('breeds', BreedController::class)->except(['show']);
    });
