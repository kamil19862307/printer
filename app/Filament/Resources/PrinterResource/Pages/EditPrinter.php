<?php

namespace App\Filament\Resources\PrinterResource\Pages;

use App\Events\PrinterNotificationRequested;
use App\Filament\Resources\PrinterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrinter extends EditRecord
{
    protected static string $resource = PrinterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('notifyManagers')
                ->label('Рассказать о новинке')
                ->icon('heroicon-o-envelope')
                ->color('primary')
                ->disabled(fn (): bool => $this->record->notified_at !== null)
                ->action(function () {

                    $this->record->refresh();

                    if ($this->record->notified_at !== null) {
                        return;
                    }

                    PrinterNotificationRequested::dispatch($this->record);
                }),

            Actions\DeleteAction::make(),
        ];
    }
}
