<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrinterController extends Controller
{
    public function show(Printer $printer)
    {
        $printer->load('images');

        $printerData = [
            'id' => $printer->id,
            'brand' => $printer->brand,
            'model' => $printer->model,
            'title' => "{$printer->brand} {$printer->model}",
            'description' => $printer->description,
            'state' => $printer->state,
            'pages_printed' => $printer->pages_printed,
            'price' => $printer->price,
            'usb' => $printer->usb,
            'wifi' => $printer->wifi,
            'ethernet' => $printer->ethernet,
            'duplex' => $printer->duplex,
            'images' => $printer->images
                ->pluck('image_path')
                ->map(fn ($path) => asset('storage/' . $path))
                ->values(),
        ];

        return Inertia::render('Printer/Show', [
            'printer' => $printerData,
        ]);
    }
}
