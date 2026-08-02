<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PrinterController extends Controller
{
    public function show($printer)
    {
        return Inertia::render('Printer/Show', [
            'printerId' => $printer,
        ]);
    }
}
