<?php

namespace App\Enums;

enum PrinterStatus: string
{
    case AVAILABLE = 'available';
    case RESERVED = 'reserved';
    case SOLD = 'sold';
}
