<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrinterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/printers/{printer}', [PrinterController::class, 'show'])
    ->name('printers.show');
