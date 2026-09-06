<?php

namespace App\Models;

use App\Enums\PrinterState;
use App\Enums\PrinterStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends Model
{
    /** @use HasFactory<\Database\Factories\PrinterFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'description',
        'price',
        'brand',
        'model',
        'cartridge',
        'state',
        'status',
        'pages_printed',
        'usb',
        'ethernet',
        'wifi',
        'duplex',
        'closed_at',
    ];

    protected $casts = [
        'state' => PrinterState::class,
        'status' => PrinterStatus::class,
    ];

    public function images(): HasMany
    {
        return $this->hasMany(PrinterImage::class)
            ->orderBy('sort');
    }
}
