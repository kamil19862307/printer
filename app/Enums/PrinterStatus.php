<?php

namespace App\Enums;

enum PrinterStatus: string
{
    case AVAILABLE = 'Доступен';
    case RESERVED = 'Зарезервирован';
    case SOLD = 'Продан';
}
