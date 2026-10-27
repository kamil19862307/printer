<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Printer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'category' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'usb' => ['sometimes', 'required', 'boolean'],
            'ethernet' => ['sometimes', 'required', 'boolean'],
            'wifi' => ['sometimes', 'required', 'boolean'],
            'duplex' => ['sometimes', 'required', 'boolean'],
        ]);

        $categoryId = ! empty($validated['category'])
            ? (int) $validated['category']
            : null;

        $printersQuery = Printer::query()
            ->where('status', '=', 'доступен')
            ->with('images');

        if ($categoryId !== null) {
            $printersQuery->where('category_id', $categoryId);
        }

        foreach (['usb', 'ethernet', 'wifi', 'duplex'] as $filter) {
            if (array_key_exists($filter, $validated)) {
                $printersQuery->where(
                    $filter,
                    filter_var($validated[$filter], FILTER_VALIDATE_BOOLEAN)
                );
            }
        }


        $printers = $printersQuery
            ->get()
            ->map(fn (Printer $printer) => [
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
            ]);

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Home', [
            'printers' => $printers,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'filters' => [
                'usb' => isset($validated['usb'])
                    ? (int) filter_var($validated['usb'], FILTER_VALIDATE_BOOLEAN)
                    : null,
                'ethernet' => isset($validated['ethernet'])
                    ? (int) filter_var($validated['ethernet'], FILTER_VALIDATE_BOOLEAN)
                    : null,
                'wifi' => isset($validated['wifi'])
                    ? (int) filter_var($validated['wifi'], FILTER_VALIDATE_BOOLEAN)
                    : null,
                'duplex' => isset($validated['duplex'])
                    ? (int) filter_var($validated['duplex'], FILTER_VALIDATE_BOOLEAN)
                    : null,
            ],
        ]);
    }
}
