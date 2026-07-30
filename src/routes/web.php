<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/printers/{printer}', function ($printer) {
    return Inertia::render('Printer/Show', [
        'printerId' => $printer,
    ]);
})->name('printers.show');
