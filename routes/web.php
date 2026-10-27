<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrinterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/printers/{printer}', [PrinterController::class, 'show'])
    ->name('printers.show');

Route::get('/download', [DownloadController::class, 'index'])
    ->name('downloads.index');

Route::get('/downloads/{download:slug}/file', [DownloadController::class, 'download'])
    ->name('downloads.download');
