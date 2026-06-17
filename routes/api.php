<?php

use App\Http\Controllers\Api\AnimalController;
use App\Http\Controllers\Api\BreedController;
use App\Http\Controllers\Api\FundraiserController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\SpeciesController;
use App\Http\Controllers\Api\StatsController;
use Illuminate\Support\Facades\Route;

Route::get('/animals', [AnimalController::class, 'index']);
Route::get('/animals/{animal}', [AnimalController::class, 'show']);
Route::get('/animals/{animal}/medical-records', [AnimalController::class, 'medicalRecords']);

Route::get('/fundraisers', [FundraiserController::class, 'index']);
Route::get('/fundraisers/{fundraiser}', [FundraiserController::class, 'show']);

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{news}', [NewsController::class, 'show']);

Route::get('/species', [SpeciesController::class, 'index']);
Route::get('/breeds', [BreedController::class, 'index']);

Route::get('/stats', [StatsController::class, 'index']);
