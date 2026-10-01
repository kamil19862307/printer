<?php

namespace App\Filament\Resources\PrinterResource\Pages;

use App\Events\PrinterNotificationRequested;
use App\Filament\Resources\PrinterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrinter extends EditRecord
{
    protected static string $resource = PrinterResource::class;

    protected function allActiveManagersNotified(): bool
    {
        $activeManagersCount = $this->record
            ->managers()
            ->where('managers.status', 'active')
            ->count();

        $sentManagersCount = $this->record
            ->managers()
            ->where('managers.status', 'active')
            ->wherePivotNotNull('sent_at')
            ->count();

        return $activeManagersCount > 0
            && $activeManagersCount === $sentManagersCount;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('notifyManagers')
                ->label('Рассказать о новинке')
                ->icon('heroicon-o-envelope')
                ->color('primary')
                ->disabled(fn (): bool => $this->allActiveManagersNotified())
                ->action(function (): void {
                    $this->record->refresh();

                    if ($this->allActiveManagersNotified()) {
                        return;
                    }

                    PrinterNotificationRequested::dispatch($this->record);
                }),

            Actions\DeleteAction::make(),
        ];
    }
}
