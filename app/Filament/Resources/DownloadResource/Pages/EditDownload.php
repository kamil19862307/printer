<?php

namespace App\Filament\Resources\DownloadResource\Pages;

use App\Filament\Resources\DownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditDownload extends EditRecord
{
    protected static string $resource = DownloadResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['file_size'] = Storage::disk('downloads')->size(
            $data['file_path']
        );

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
