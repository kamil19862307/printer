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
        Schema::create('printer_manager', function (Blueprint $table) {
            $table->id();

            $table->foreignId('printer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('manager_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamp('sent_at')
                ->nullable();

            $table->string('status')
                ->nullable();

            $table->timestamps();

            $table->unique(['printer_id', 'manager_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printer_manager');
    }
};
