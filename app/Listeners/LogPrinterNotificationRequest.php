<?php

namespace App\Listeners;

use App\Events\PrinterNotificationRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogPrinterNotificationRequest
{
    public function __construct()
    {
    }

    public function handle(PrinterNotificationRequested $event): void
    {
//        Log::info("Printer notification requested", [
//            'printer_id' => $event->printer->id,
//            'printer' => $event->printer->brand . ' ' . $event->printer->model,
//        ]);
    }
}
