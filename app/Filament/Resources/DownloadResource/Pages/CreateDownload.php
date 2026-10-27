<?php

namespace App\Filament\Resources\DownloadResource\Pages;

use App\Filament\Resources\DownloadResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateDownload extends CreateRecord
{
    protected static string $resource = DownloadResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['file_size'] = Storage::disk('downloads')->size(
            $data['file_path']
        );

        return $data;
    }
}
