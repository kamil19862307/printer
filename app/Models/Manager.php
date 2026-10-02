<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class Manager extends Model
{
    use Notifiable;
    protected $fillable = [
        'name',
        'email',
        'status',
    ];

    public function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function printers(): BelongsToMany
    {
        return $this->belongsToMany(Printer::class, 'printer_manager')
            ->withPivot('sent_at', 'status')
            ->withTimestamps();
    }
}
