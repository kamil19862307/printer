<?php

namespace App\Jobs;

use App\Models\Manager;
use App\Models\Printer;
use App\Notifications\NewPrinterNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNewPrinterNotification implements ShouldQueue
{
    use Batchable, Queueable;

    public function __construct(
        public Manager $manager,
        public Printer $printer
    ) {
    }

    public function handle(): void
    {
        $this->manager->notify(
            new NewPrinterNotification($this->printer)
        );
    }
}
