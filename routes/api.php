<?php

use App\Http\Controllers\Api\AnimalController;
use Illuminate\Support\Facades\Route;

Route::get('/animals', [AnimalController::class, 'index']);
