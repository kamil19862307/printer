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
        $printer = $event->printer;

        $managers = Manager::query()
            ->where('status', '=', true)
            ->get();

        $jobs = [];
        foreach ($managers as $manager) {
            $pivot = $printer->managers()->whereKey($manager->id)->first();

            if ($pivot === null) {
                $printer->managers()->attach($manager->id);
                $sentAt = null;
            } else {
                $sentAt = $pivot->pivot->sent_at;
            }

            if ($sentAt !== null) {
                continue;
            }

            $jobs[] = new SendNewPrinterNotification(
                $manager,
                $printer,
            );

            if ($jobs === []){
                return;
            }
        }

        Bus::batch($jobs)
            ->name('Уведомление о новом принтере')
            ->dispatch();

    }
}
