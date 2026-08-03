<?php

use App\Enums\PrinterBrands;
use App\Enums\PrinterState;
use App\Enums\PrinterStatus;
use App\Enums\PrinterType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();

            $table->enum('type', array_column(PrinterType::cases(), 'value'));
            $table->text('description')
                ->nullable();
            $table->integer('price');
            $table->enum('brand', array_column(PrinterBrands::cases(), 'value'));
            $table->string('model');
            $table->string('cartridge'); // CF226A, TN-2375, TK-1170
            $table->enum('state', array_column(PrinterState::cases(), 'value'));
            $table->unsignedInteger('pages_printed')
                ->nullable();
            $table->boolean('usb')
                ->nullable();
            $table->boolean('ethernet')
                ->nullable();
            $table->boolean('wifi')
                ->nullable();
            $table->boolean('duplex')
                ->nullable();
            $table->enum('status', array_column(PrinterStatus::cases(), 'value'))
                ->nullable();
            $table->timestamp('closed_at')
                ->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
