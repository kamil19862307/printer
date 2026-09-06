<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $printers = Printer::query()
            ->with('images')
            ->get()
            ->map(fn (Printer $printer) => [
                'id' => $printer->id,
                'brand' => $printer->brand,
                'model' => $printer->model,
                'title' => "{$printer->brand} {$printer->model}",
                'description' => $printer->description,
                'state' => $printer->state->value,
                'price' => $printer->price,
                'usb' => $printer->usb,
                'wifi' => $printer->wifi,
                'ethernet' => $printer->ethernet,
                'duplex' => $printer->duplex,
                'images' => $printer->images
                    ->pluck('image_path')
                    ->map(fn ($path) => asset('storage/' . $path))
                    ->values(),
            ]);

        return Inertia::render('Home', [
            'printers' => $printers,
        ]);
    }
}
