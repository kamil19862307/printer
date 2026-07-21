<?php

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

            $table->string('title')->nullable();
            $table->enum('type', [
                'printer',
                'mfp'
            ]);
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('price')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('cartridge')->nullable(); // CF226A, TN-2375, TK-1170
            $table->string('state')->nullable(); // Новый, почти новый и т.д.
            $table->integer('pages_printed')->nullable();
            $table->boolean('ethernet')->nullable();
            $table->boolean('wifi')->nullable();
            $table->boolean('duplex')->nullable();
            $table->enum('status', [
                'available',
                'reserved',
                'sold'
            ])->default('available');
            $table->timestamp('closed_at')->nullable();
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
