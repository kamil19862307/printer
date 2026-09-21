<?php

namespace App\Listeners;

use App\Events\PrinterNotificationRequested;
use App\Jobs\SendNewPrinterNotification;
use App\Models\Manager;
use App\Models\Printer;
use App\Notifications\NewPrinterNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class NotifyActiveManagers
{
    public function __construct()
    {
    }

    public function handle(PrinterNotificationRequested $event): void
    {
        $managers = Manager::query()
            ->where('status', '=', 'active')
            ->get();

        $jobs = $managers->map(
            fn (Manager $manager) => new SendNewPrinterNotification(
                $manager,
                $event->printer
            )
        )->all();

        if ($jobs === []) {
            return;
        }

        $printerId = $event->printer->id;

        Bus::batch($jobs)
            ->name('Уведомление о новом принтере')
            ->then(function (Batch $batch) use ($printerId) {
                Printer::whereKey($printerId)->update([
                    'notified_at' => now(),
                ]);
            })
            ->dispatch();
    }
}
