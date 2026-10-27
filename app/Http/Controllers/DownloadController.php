<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\DownloadCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    public function index(): Response
    {
        $categories = DownloadCategory::query()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get(['id', 'name', 'slug']);

        $downloads = Download::query()
            ->with('category:id,name,slug')
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->latest()
            ->get([
                'id',
                'download_category_id',
                'name',
                'slug',
                'description',
                'version',
                'operating_system',
                'architecture',
                'file_size',
            ]);

        return Inertia::render('Download', [
            'categories' => $categories,
            'downloads' => $downloads,
        ]);
    }

    public function download(Download $download): StreamedResponse
    {
        abort_unless($download->is_active, 404);

        abort_unless(
            $download->category()->where('is_active', true)->exists(),
            404
        );

        $disk = Storage::disk('downloads');

        abort_unless($disk->exists($download->file_path), 404);

        return $disk->download(
            $download->file_path,
            $download->original_filename
        );
    }
}
