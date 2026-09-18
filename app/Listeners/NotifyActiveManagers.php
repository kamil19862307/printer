<?php

namespace App\Listeners;

use App\Events\PrinterNotificationRequested;
use App\Models\Manager;
use App\Notifications\NewPrinterNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyActiveManagers
{
    public function __construct()
    {
    }

    public function handle(PrinterNotificationRequested $event): void
    {
        $managers = Manager::query()->where('status', '=', 'active')->get();

        foreach ($managers as $manager) {
            $manager->notify(
                new NewPrinterNotification($event->printer)
            );
        }
    }
}
