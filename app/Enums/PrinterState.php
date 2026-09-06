<?php

namespace App\Enums;

enum PrinterState: string
{
    case NEW = 'Новый';
    case LIKE_NEW = 'Как новый';
    case ALMOST_LIKE_NEW = 'Почти как новый';
    case GOOD = 'В хорошем состоянии';
    case USED = 'Есть потёртости';
}
