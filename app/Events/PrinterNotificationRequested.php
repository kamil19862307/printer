<?php

namespace App\Events;

use App\Models\Printer;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrinterNotificationRequested
{
    use Dispatchable, SerializesModels;

    public function __construct(public Printer $printer)
    {
    }
}
